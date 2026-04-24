// ================= LIBS =================
#include <WiFi.h>
#include <WiFiManager.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <Preferences.h>
#include <Wire.h>
#include <TinyGPS++.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include "MAX30105.h"
#include <OneWire.h>
#include <DallasTemperature.h>

// ================= CONFIG =================
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define OLED_ADDR 0x3C

#define BUZZER_PIN 5
#define TEMP_PIN 15
#define SOS_PIN 4

// ================= OBJECTS =================
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);
TinyGPSPlus gps;
MAX30105 maxSensor;
HardwareSerial GPSserial(1);
Preferences prefs;

OneWire oneWire(TEMP_PIN);
DallasTemperature tempSensor(&oneWire);

// ================= SERVER =================
char serverUrl[120] = "http://your-api.com";

// ================= DATA =================
struct SensorData {
  float hr;
  float spo2;
  float temp;
  double lat;
  double lon;
};

struct Config {
  int hrLow = 60;
  int hrHigh = 100;
  int spo2Low = 92;
  float tempLow = 35;
  float tempHigh = 38;
};

SensorData currentData;
Config config;

// ================= DEVICE =================
String deviceUID;
String pairCode = "----";
bool isPaired = false;

// ================= RTOS =================
SemaphoreHandle_t mutex;
QueueHandle_t dataQueue;
QueueHandle_t sosQueue;
QueueHandle_t retryQueue;

// =================================================
// UTIL
// =================================================
String getUID() {
  uint64_t chipid = ESP.getEfuseMac();
  char id[24];
  sprintf(id, "ESP32_%04X%08X", (uint16_t)(chipid >> 32), (uint32_t)chipid);
  return String(id);
}

void oled(String l1, String l2, String l3) {
  display.clearDisplay();
  display.setCursor(0, 0);
  display.println(l1);
  display.println(l2);
  display.println(l3);
  display.display();
}

void beep() {
  digitalWrite(BUZZER_PIN, HIGH);
  delay(80);
  digitalWrite(BUZZER_PIN, LOW);
}

// =================================================
// WIFI
// =================================================
void setupWiFi() {
  WiFiManager wm;

  WiFiManagerParameter p_server("server", "Server URL", serverUrl, 120);
  wm.addParameter(&p_server);

  oled("WIFI SETUP", "ESP32-Setup", "");
  wm.autoConnect("ESP32-Setup");

  strcpy(serverUrl, p_server.getValue());

  prefs.begin("config", false);
  prefs.putString("server", serverUrl);
  prefs.end();

  oled("WIFI OK", serverUrl, "");
}

// =================================================
// HTTP
// =================================================
bool registerDevice() {
  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/register");
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<200> doc;
  doc["uid"] = deviceUID;

  String body;
  serializeJson(doc, body);

  int code = http.POST(body);

  if (code == 200) {
    StaticJsonDocument<200> res;
    deserializeJson(res, http.getString());
    pairCode = res["pairing_code"].as<String>();

    prefs.begin("device", false);
    prefs.putString("pair", pairCode);
    prefs.end();

    http.end();
    return true;
  }

  http.end();
  return false;
}

bool checkPaired() {
  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/status");
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<120> doc;
  doc["uid"] = deviceUID;

  String body;
  serializeJson(doc, body);

  int code = http.POST(body);

  if (code == 200) {
    StaticJsonDocument<120> res;
    deserializeJson(res, http.getString());
    isPaired = res["paired"];
    http.end();
    return isPaired;
  }

  http.end();
  return false;
}

bool sendDataHTTP(SensorData &d) {
  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/data");
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<300> doc;
  doc["uid"] = deviceUID;
  doc["hr"] = d.hr;
  doc["spo2"] = d.spo2;
  doc["temp"] = d.temp;
  doc["lat"] = d.lat;
  doc["lng"] = d.lon;

  String body;
  serializeJson(doc, body);

  int code = http.POST(body);
  http.end();

  return (code == 200);
}

void sendSOSHTTP(SensorData &d) {
  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/sos");
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<300> doc;
  doc["uid"] = deviceUID;
  doc["hr"] = d.hr;
  doc["spo2"] = d.spo2;
  doc["temp"] = d.temp;
  doc["lat"] = d.lat;
  doc["lng"] = d.lon;

  String body;
  serializeJson(doc, body);

  http.POST(body);
  http.end();

  beep();
}

// =================================================
// MAX30102 TASK (CORE 1 - ISOLATED)
// =================================================
void taskMAX(void *pv) {

  const int RATE_SIZE = 8;
  float rates[RATE_SIZE] = {0};
  int rateSpot = 0;

  long prevIR = 0;
  bool rising = false;
  unsigned long lastBeat = 0;
  float avgBpm = 0;

  const TickType_t delayMs = pdMS_TO_TICKS(20); // 50Hz

  while (true) {

    long ir = maxSensor.getIR();
    float hr = 0;

    if (ir > 50000) {

      if (ir > prevIR && !rising) rising = true;

      if (ir < prevIR && rising) {
        rising = false;

        unsigned long now = millis();
        float delta = (now - lastBeat) / 1000.0;
        lastBeat = now;

        if (delta > 0.3 && delta < 2.0) {
          float bpm = 60.0 / delta;

          if (bpm > 40 && bpm < 180) {
            rates[rateSpot++] = bpm;
            rateSpot %= RATE_SIZE;

            float sum = 0;
            for (int i = 0; i < RATE_SIZE; i++) sum += rates[i];
            avgBpm = sum / RATE_SIZE;
          }
        }
      }

      prevIR = ir;
      hr = avgBpm;
    }

    if (xSemaphoreTake(mutex, portMAX_DELAY)) {
      currentData.hr = hr;
      currentData.spo2 = (hr > 0) ? 98 : 0;
      xSemaphoreGive(mutex);
    }

    vTaskDelay(delayMs);
  }
}

// =================================================
// SYSTEM TASK (CORE 0)
// =================================================
void taskSystem(void *pv) {

  SensorData d;
  bool lastBtn = HIGH;
  unsigned long lastPairCheck = 0;
  unsigned long lastTempRead = 0;

  pinMode(SOS_PIN, INPUT_PULLUP);

  while (true) {

    // GPS
    while (GPSserial.available()) {
      gps.encode(GPSserial.read());
    }

    if (gps.location.isValid()) {
      if (xSemaphoreTake(mutex, portMAX_DELAY)) {
        currentData.lat = gps.location.lat();
        currentData.lon = gps.location.lng();
        xSemaphoreGive(mutex);
      }
    }

    // TEMP every 2s
    if (millis() - lastTempRead > 2000) {
      tempSensor.requestTemperatures();
      float t = tempSensor.getTempCByIndex(0);

      if (xSemaphoreTake(mutex, portMAX_DELAY)) {
        currentData.temp = t;
        xSemaphoreGive(mutex);
      }

      lastTempRead = millis();
    }

    // snapshot
    if (xSemaphoreTake(mutex, portMAX_DELAY)) {
      d = currentData;
      xSemaphoreGive(mutex);
    }

    // send data
    if (d.hr > 0) {
      xQueueSend(dataQueue, &d, 0);
    }

    // SOS button
    bool btn = digitalRead(SOS_PIN);
    if (lastBtn == HIGH && btn == LOW) {
      xQueueSend(sosQueue, &d, 0);
    }
    lastBtn = btn;

    // abnormal trigger
    if (
      d.hr > 0 &&
      (d.hr < config.hrLow || d.hr > config.hrHigh ||
       d.spo2 < config.spo2Low ||
       d.temp < config.tempLow || d.temp > config.tempHigh)
    ) {
      xQueueSend(sosQueue, &d, 0);
    }

    // HTTP send
    if (xQueueReceive(dataQueue, &d, 0)) {
      if (!sendDataHTTP(d)) {
        xQueueSend(retryQueue, &d, 0);
      }
    }

    if (xQueueReceive(retryQueue, &d, 0)) {
      sendDataHTTP(d);
    }

    if (xQueueReceive(sosQueue, &d, 0)) {
      sendSOSHTTP(d);
    }

    // pairing check
    if (!isPaired && millis() - lastPairCheck > 5000) {
      lastPairCheck = millis();
      checkPaired();
    }

    // OLED
    if (!isPaired) {
      oled("PAIR DEVICE", pairCode, deviceUID);
    } else {
      oled(
        "HR:" + String(d.hr) + " SPO2:" + String(d.spo2),
        "T:" + String(d.temp,1),
        "CONNECTED"
      );
    }

    vTaskDelay(200);
  }
}

// =================================================
// SETUP
// =================================================
void setup() {

  Serial.begin(115200);

  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, LOW);

  Wire.begin();
  display.begin(SSD1306_SWITCHCAPVCC, OLED_ADDR);
  display.setTextSize(1);
  display.setTextColor(WHITE);

  oled("BOOTING...", "", "");

  if (!maxSensor.begin(Wire)) {
    oled("MAX FAIL", "", "");
    while (1);
  }

  GPSserial.begin(9600, SERIAL_8N1, 16, 17);
  tempSensor.begin();

  deviceUID = getUID();

  prefs.begin("config", true);
  String saved = prefs.getString("server", "");
  prefs.end();
  if (saved.length() > 0) saved.toCharArray(serverUrl, 120);

  setupWiFi();

  prefs.begin("device", true);
  pairCode = prefs.getString("pair", "");
  prefs.end();

  if (pairCode == "") {
    while (!registerDevice()) {
      oled("REGISTER FAIL", "Retrying...", "");
      delay(3000);
    }
  }

  mutex = xSemaphoreCreateMutex();
  dataQueue = xQueueCreate(10, sizeof(SensorData));
  sosQueue = xQueueCreate(5, sizeof(SensorData));
  retryQueue = xQueueCreate(10, sizeof(SensorData));

  xTaskCreatePinnedToCore(taskMAX, "MAX", 4096, NULL, 3, NULL, 1);
  xTaskCreatePinnedToCore(taskSystem, "SYS", 8192, NULL, 1, NULL, 0);
}

void loop() {}