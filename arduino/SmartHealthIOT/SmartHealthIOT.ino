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

String deviceUID;
String pairCode = "----";
bool isPaired = false;

// ---------------- UID ----------------
String getUID() {
  uint64_t chipid = ESP.getEfuseMac();
  char id[17];
  sprintf(id, "%04X%08X", (uint16_t)(chipid >> 32), (uint32_t)chipid);
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

// ---------------- WIFI SETUP ----------------
void setupWiFi() {
  // Load saved server
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

  // Save server after config
  strcpy(serverUrl, custom_server.getValue());

  prefs.begin("config", false);
  prefs.putString("server", serverUrl);
  prefs.end();

  oled("WIFI OK", serverUrl, "");
}

// ---------------- HTTP ----------------
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

    // 💾 SAVE pairing code (avoid re-register)
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
  http.begin(String(serverUrl) + "/api/device/check-pair?uid=" + deviceUID);

  int code = http.GET();

  if (code == 200) {
    StaticJsonDocument<200> res;
    deserializeJson(res, http.getString());

    isPaired = res["paired"];
    http.end();
    return isPaired;
  }

  http.end();
  return false;
}

void sendData() {
  if (!isPaired) return;

  HTTPClient http;
  http.begin(String(serverUrl) + "/api/device/data");
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<300> doc;
  doc["uid"] = deviceUID;

  if (xSemaphoreTake(mutex, portMAX_DELAY)) {
    doc["hr"] = data.hr;
    doc["spo2"] = data.spo2;
    doc["lat"] = data.lat;
    doc["lon"] = data.lon;
    xSemaphoreGive(mutex);
  }

  String body;
  serializeJson(doc, body);

  http.POST(body);
  http.end();
}

// ---------------- MAX30102 TASK (CORE 1) ----------------
void taskMAX(void *pv) {
  while (true) {
    long ir = maxSensor.getIR();

    float hr = ir % 100; // replace with real algo
    float spo2 = 98;

    if (xSemaphoreTake(mutex, portMAX_DELAY)) {
      data.hr = hr;
      data.spo2 = spo2;
      xSemaphoreGive(mutex);
    }

    vTaskDelay(1);
  }
}

// ---------------- SYSTEM TASK (CORE 0) ----------------
void taskSYS(void *pv) {
  unsigned long lastSend = 0;
  unsigned long lastPairCheck = 0;

  while (true) {

    // GPS read
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

    // pairing check
    if (!isPaired && millis() - lastPairCheck > 3000) {
      lastPairCheck = millis();
      checkPaired();
    }

    // send data
    if (isPaired && millis() - lastSend > 5000) {
      lastSend = millis();
      sendData();
    }

    // OLED display
    if (!isPaired) {
      oled("PAIR DEVICE", "UID:" + deviceUID, "CODE:" + pairCode);
    } else {
      String line1, line2;

      if (xSemaphoreTake(mutex, portMAX_DELAY)) {
        line1 = "HR:" + String(data.hr) + " SPO2:" + String(data.spo2);
        line2 = String(data.lat,4) + "," + String(data.lon,4);
        xSemaphoreGive(mutex);
      }

      oled(line1, line2, "CONNECTED");
    }

    vTaskDelay(100);
  }
}

// ---------------- SETUP ----------------
void setup() {
  Serial.begin(115200);

  Wire.begin();
  Wire.setClock(400000);

  display.begin(SSD1306_SWITCHCAPVCC, OLED_ADDR);
  display.setTextSize(1);
  display.setTextColor(WHITE);

  oled("BOOTING...", "", "");

  // MAX30102
  if (!maxSensor.begin(Wire)) {
    oled("MAX30102 FAIL", "", "");
    while (1);
  }

  // GPS
  GPSserial.begin(9600, SERIAL_8N1, 16, 17);

  // UID
  deviceUID = getUID();

  // WiFi + server config
  setupWiFi();

  // request pairing
  requestPair();

  // mutex
  mutex = xSemaphoreCreateMutex();

  // tasks
  xTaskCreatePinnedToCore(taskMAX, "MAX", 4096, NULL, 2, NULL, 1);
  xTaskCreatePinnedToCore(taskSYS, "SYS", 8192, NULL, 1, NULL, 0);
}

void loop() {}