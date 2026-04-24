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

// ---------------- CONFIG ----------------
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define OLED_ADDR 0x3C

// ---------------- OBJECTS ----------------
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);
TinyGPSPlus gps;
MAX30105 maxSensor;
HardwareSerial GPSserial(1);
Preferences prefs;

// ---------------- WIFI MANAGER ----------------
char serverUrl[100] = "http://your-api.com";

// ---------------- DATA ----------------
struct SensorData {
  float hr;
  float spo2;
  double lat;
  double lon;
};

SensorData data;
SemaphoreHandle_t mutex;

// ---------------- DEVICE STATE ----------------
String deviceUID;
String pairCode = "----";
bool isPaired = false;

// ---------------- UID ----------------
String getUID() {
  uint64_t chipid = ESP.getEfuseMac();
  char id[20];
  sprintf(id, "ESP32_%04X%08X", (uint16_t)(chipid >> 32), (uint32_t)chipid);
  return String(id);
}

// ---------------- OLED ----------------
void oled(String l1, String l2, String l3) {
  display.clearDisplay();
  display.setCursor(0,0);
  display.println(l1);
  display.println(l2);
  display.println(l3);
  display.display();
}

// ---------------- WIFI ----------------
void setupWiFi() {
  prefs.begin("config", true);
  String saved = prefs.getString("server", "");
  prefs.end();

  if (saved.length() > 0) {
    saved.toCharArray(serverUrl, 100);
  }

  WiFiManager wm;

  WiFiManagerParameter custom_server(
    "server",
    "Server URL",
    serverUrl,
    100
  );

  wm.addParameter(&custom_server);

  oled("CONNECT WIFI", "AP: ESP32-Setup", "");
  wm.autoConnect("ESP32-Setup");

  strcpy(serverUrl, custom_server.getValue());

  prefs.begin("config", false);
  prefs.putString("server", serverUrl);
  prefs.end();

  oled("WIFI OK", serverUrl, "");
}

// ---------------- REGISTER DEVICE ----------------
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

// ---------------- CHECK PAIR ----------------
bool checkPaired() {
  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/status");
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<100> doc;
  doc["uid"] = deviceUID;

  String body;
  serializeJson(doc, body);

  int code = http.POST(body);

  if (code == 200) {
    StaticJsonDocument<100> res;
    deserializeJson(res, http.getString());

    isPaired = res["paired"];
    http.end();
    return isPaired;
  }

  http.end();
  return false;
}

// ---------------- SEND DATA ----------------
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

// ---------------- SENSOR TASK (CORE 1) ----------------
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

    vTaskDelay(10);
  }
}

// ---------------- SYSTEM TASK (CORE 0) ----------------
void taskSystem(void *pv) {

  unsigned long lastPairCheck = 0;
  unsigned long lastSend = 0;

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

    // Check pairing
    if (!isPaired && millis() - lastPairCheck > 5000) {
      lastPairCheck = millis();
      checkPaired();
    }

    // Send data
    if (isPaired && millis() - lastSend > 5000) {
      lastSend = millis();
      sendData();
    }

    // OLED UI
    if (!isPaired) {
      oled("PAIR DEVICE", pairCode, deviceUID);
    } else {
      String l1, l2;

      if (xSemaphoreTake(mutex, portMAX_DELAY)) {
        l1 = "HR:" + String(data.hr) + " SPO2:" + String(data.spo2);
        l2 = String(data.lat,4) + "," + String(data.lon,4);
        xSemaphoreGive(mutex);
      }

      oled(l1, l2, "CONNECTED");
    }

    vTaskDelay(200);
  }
}

// ---------------- SETUP ----------------
void setup() {
  Serial.begin(115200);

  Wire.begin();
  display.begin(SSD1306_SWITCHCAPVCC, OLED_ADDR);
  display.setTextSize(1);
  display.setTextColor(WHITE);

  oled("BOOTING...", "", "");

  // Sensors
  if (!maxSensor.begin(Wire)) {
    oled("MAX30102 FAIL", "", "");
    while (1);
  }

  GPSserial.begin(9600, SERIAL_8N1, 16, 17);

  deviceUID = getUID();

  // WiFi
  setupWiFi();

  // Load saved pairing code
  prefs.begin("device", true);
  String saved = prefs.getString("pair", "");
  prefs.end();

  if (saved.length() > 0) {
    pairCode = saved;
  } else {
    while (!registerDevice()) {
      oled("REGISTER FAIL", "Retrying...", "");
      delay(3000);
    }
  }

  // Mutex
  mutex = xSemaphoreCreateMutex();

  // Tasks
  xTaskCreatePinnedToCore(taskSensor, "SENSOR", 4096, NULL, 2, NULL, 1);
  xTaskCreatePinnedToCore(taskSystem, "SYSTEM", 8192, NULL, 1, NULL, 0);
}

void loop() {}