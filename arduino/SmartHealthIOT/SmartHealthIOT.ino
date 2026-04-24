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

// ================= OLED =================
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define OLED_ADDR 0x3C

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);

// ================= PINS =================
#define SOS_PIN 4

// ================= GPS =================
TinyGPSPlus gps;
HardwareSerial GPSserial(1);

// ================= SENSOR =================
MAX30105 maxSensor;

// ================= STORAGE =================
Preferences prefs;

// ================= SERVER =================
char serverUrl[120] = "http://your-api.com";

// ================= DATA =================
struct SensorData {
  float hr;
  float spo2;
  double lat;
  double lon;
};

struct Config {
  int hrLow = 60;
  int hrHigh = 100;
  int spo2Low = 92;
  int spo2High = 100;
  float tempLow = 35;
  float tempHigh = 38;
};

SensorData data;
Config config;

// ================= DEVICE =================
String deviceUID;
String pairCode = "----";
bool isPaired = false;

// ================= MUTEX =================
SemaphoreHandle_t mutex;

// =================================================
// OLED
// =================================================
void oled(String l1, String l2, String l3) {
  display.clearDisplay();
  display.setCursor(0, 0);
  display.println(l1);
  display.println(l2);
  display.println(l3);
  display.display();
}

// =================================================
// UID
// =================================================
String getUID() {
  uint64_t chipid = ESP.getEfuseMac();
  char id[24];
  sprintf(id, "ESP32_%04X%08X", (uint16_t)(chipid >> 32), (uint32_t)chipid);
  return String(id);
}

// =================================================
// WIFI SETUP (WiFiManager)
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
// REGISTER DEVICE
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

// =================================================
// CHECK PAIR STATUS
// =================================================
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

// =================================================
// OPTIONAL: ONE-TIME CONFIG SYNC (AFTER PAIRING)
// =================================================
void fetchConfigOnce() {

  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/config?uid=" + deviceUID);

  int code = http.GET();

  if (code == 200) {
    StaticJsonDocument<300> res;
    deserializeJson(res, http.getString());

    config.hrLow = res["hr_low"] | config.hrLow;
    config.hrHigh = res["hr_high"] | config.hrHigh;
    config.spo2Low = res["spo2_low"] | config.spo2Low;
    config.spo2High = res["spo2_high"] | config.spo2High;
  }

  http.end();
}

// =================================================
// SEND DATA
// =================================================
void sendData() {

  if (!isPaired) return;

  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/data");
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<300> doc;
  doc["uid"] = deviceUID;

  if (xSemaphoreTake(mutex, portMAX_DELAY)) {
    doc["heart_rate"] = data.hr;
    doc["spo2"] = data.spo2;
    doc["lat"] = data.lat;
    doc["lng"] = data.lon;
    xSemaphoreGive(mutex);
  }

  String body;
  serializeJson(doc, body);

  http.POST(body);
  http.end();
}

// =================================================
// SOS ALERT
// =================================================
void sendSOS() {

  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/sos");
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<250> doc;
  doc["uid"] = deviceUID;
  doc["hr"] = data.hr;
  doc["spo2"] = data.spo2;
  doc["lat"] = data.lat;
  doc["lng"] = data.lon;

  String body;
  serializeJson(doc, body);

  http.POST(body);
  http.end();

  oled("🚨 SOS SENT", "EMERGENCY", "");
}

// =================================================
// SENSOR TASK (CORE 1)
// =================================================
void taskSensor(void *pv) {

  while (true) {

    long ir = maxSensor.getIR();

    float hr = constrain(ir % 120, 60, 100);
    float spo2 = 98;

    if (xSemaphoreTake(mutex, portMAX_DELAY)) {
      data.hr = hr;
      data.spo2 = spo2;
      xSemaphoreGive(mutex);
    }

    // AUTO SOS
    if (hr < config.hrLow || hr > config.hrHigh || spo2 < config.spo2Low) {
      sendSOS();
    }

    vTaskDelay(10);
  }
}

// =================================================
// SYSTEM TASK (CORE 0)
// =================================================
void taskSystem(void *pv) {

  unsigned long lastSend = 0;
  unsigned long lastCheck = 0;
  bool lastBtn = HIGH;

  pinMode(SOS_PIN, INPUT_PULLUP);

  while (true) {

    // GPS
    while (GPSserial.available()) {
      gps.encode(GPSserial.read());
    }

    if (gps.location.isValid()) {
      if (xSemaphoreTake(mutex, portMAX_DELAY)) {
        data.lat = gps.location.lat();
        data.lon = gps.location.lng();
        xSemaphoreGive(mutex);
      }
    }

    // SOS BUTTON
    bool btn = digitalRead(SOS_PIN);
    if (lastBtn == HIGH && btn == LOW) {
      sendSOS();
    }
    lastBtn = btn;

    // CHECK PAIRING
    if (!isPaired && millis() - lastCheck > 5000) {
      lastCheck = millis();
      checkPaired();
    }

    // SEND DATA
    if (isPaired && millis() - lastSend > 5000) {
      lastSend = millis();
      sendData();
    }

    // OLED
    if (!isPaired) {
      oled("PAIR DEVICE", pairCode, deviceUID);
    } else {
      String l1, l2;

      if (xSemaphoreTake(mutex, portMAX_DELAY)) {
        l1 = "HR:" + String(data.hr) + " SPO2:" + String(data.spo2);
        l2 = String(data.lat, 4) + "," + String(data.lon, 4);
        xSemaphoreGive(mutex);
      }

      oled(l1, l2, "CONNECTED");
    }

    vTaskDelay(200);
  }
}

// =================================================
// SETUP
// =================================================
void setup() {

  Serial.begin(115200);

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

  deviceUID = getUID();

  // load saved server
  prefs.begin("config", true);
  String savedServer = prefs.getString("server", "");
  prefs.end();

  if (savedServer.length() > 0) {
    savedServer.toCharArray(serverUrl, 120);
  }

  setupWiFi();

  // load pairing
  prefs.begin("device", true);
  String savedPair = prefs.getString("pair", "");
  prefs.end();

  if (savedPair.length() > 0) {
    pairCode = savedPair;
  } else {
    while (!registerDevice()) {
      oled("REGISTER FAIL", "Retrying...", "");
      delay(3000);
    }
  }

  mutex = xSemaphoreCreateMutex();

  // OPTIONAL config sync AFTER pairing only
  if (pairCode.length() > 0) {
    fetchConfigOnce();
  }

  xTaskCreatePinnedToCore(taskSensor, "SENSOR", 4096, NULL, 2, NULL, 1);
  xTaskCreatePinnedToCore(taskSystem, "SYSTEM", 8192, NULL, 1, NULL, 0);
}

void loop() {}