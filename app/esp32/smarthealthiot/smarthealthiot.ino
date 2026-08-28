#include <WiFi.h>
#include <WiFiManager.h>
#include <HTTPClient.h>
#include <Wire.h>
#include <Preferences.h>

#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>

#include <Adafruit_MLX90614.h>

#include "MAX30105.h"
#include "heartRate.h"
#include "spo2_algorithm.h"


// =====================================================
// DEVICE CONFIGURATION
// =====================================================

// Give each physical ESP32 a unique UID
#define DEVICE_UID "ESP32-001"


// =====================================================
// LARAVEL API
// =====================================================

// Change this to the IP address of your Laravel PC
//
// IMPORTANT:
// Do NOT use localhost or 127.0.0.1 here.
//
// Example:
// PC running Laravel = 192.168.1.100
//
const char* API_BASE_URL =
    "http://192.168.1.100:8000/api";


// Device pairing endpoints
const char* PAIR_REQUEST_URL =
    "http://192.168.1.100:8000/api/device/pair/request";

const char* PAIR_STATUS_URL =
    "http://192.168.1.100:8000/api/device/pair/status";


// Sensor reading endpoint
const char* READINGS_URL =
    "http://192.168.1.100:8000/api/device/readings";


// =====================================================
// PERSISTENT STORAGE
// =====================================================

Preferences preferences;


// Laravel authentication token
String deviceToken = "";


// Temporary registration code
String pairingCode = "";


// Device registration state
bool deviceRegistered = false;


// Whether Laravel has received our pairing request
bool pairingRequested = false;


// =====================================================
// REGISTRATION TIMERS
// =====================================================

unsigned long lastPairingRequest = 0;

unsigned long lastPairingCheck = 0;


// Retry pairing request every 5 seconds
const unsigned long PAIR_REQUEST_INTERVAL = 5000;


// Check pairing status every 3 seconds
const unsigned long PAIR_STATUS_INTERVAL = 3000;


// =====================================================
// GPIO
// =====================================================

#define I2C_SDA 21
#define I2C_SCL 22

#define BUZZER_PIN 25


// =====================================================
// OLED
// =====================================================

#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64


Adafruit_SSD1306 display(
    SCREEN_WIDTH,
    SCREEN_HEIGHT,
    &Wire,
    -1
);


// =====================================================
// MLX90614
// =====================================================

Adafruit_MLX90614 mlx =
    Adafruit_MLX90614();


// =====================================================
// MAX30102
// =====================================================

MAX30105 particleSensor;


// =====================================================
// HEART RATE
// =====================================================

const byte RATE_SIZE = 4;

byte rates[RATE_SIZE];

byte rateSpot = 0;

long lastBeat = 0;

float beatsPerMinute = 0;

int beatAvg = 0;


// =====================================================
// SPO2
// =====================================================

uint32_t irBuffer[100];

uint32_t redBuffer[100];

int32_t bufferLength;

int32_t spo2 = 0;

int8_t validSPO2 = 0;

int32_t heartRate = 0;

int8_t validHeartRate = 0;


// =====================================================
// SENSOR VALUES
// =====================================================

float bodyTemperature = 0.0;

float ambientTemperature = 0.0;

int batteryLevel = 100;


// =====================================================
// TIMERS
// =====================================================

unsigned long lastApiSend = 0;

unsigned long lastSpO2Calculation = 0;


// Send readings every 10 seconds
const unsigned long API_INTERVAL = 10000;


// Calculate SpO2 every 15 seconds
const unsigned long SPO2_INTERVAL = 15000;


// =====================================================
// FORWARD DECLARATIONS
// =====================================================

void beep(int duration);

void alertBeep();

void setupWiFi();

void loadDeviceToken();

void saveDeviceToken(String token);

void generatePairingCode();

void displayPairingCode();

void displayWaitingForRegistration();

bool sendPairingRequest();

bool checkPairingStatus();

void handleRegistration();

void readSensors();

void calculateSpO2();

void updateDisplay();

void checkAlerts();

void sendToLaravel();


// =====================================================
// SETUP
// =====================================================

void setup()
{
    Serial.begin(115200);

    delay(1000);


    Serial.println();
    Serial.println(
        "================================="
    );

    Serial.println(
        " Smart Health IoT ESP32"
    );

    Serial.println(
        "================================="
    );


    // =================================================
    // GPIO
    // =================================================

    pinMode(
        BUZZER_PIN,
        OUTPUT
    );

    digitalWrite(
        BUZZER_PIN,
        LOW
    );


    // =================================================
    // I2C
    // =================================================

    Wire.begin(
        I2C_SDA,
        I2C_SCL
    );

    Serial.println(
        "I2C initialized"
    );


    // =================================================
    // OLED
    // =================================================

    if (
        !display.begin(
            SSD1306_SWITCHCAPVCC,
            0x3C
        )
    )
    {
        Serial.println(
            "OLED not found!"
        );

        while (true)
        {
            beep(100);

            delay(1000);
        }
    }


    display.clearDisplay();

    display.setTextColor(
        SSD1306_WHITE
    );

    display.setTextSize(1);

    display.setCursor(0, 0);

    display.println(
        "Smart Health IoT"
    );

    display.println();

    display.println(
        "Starting..."
    );

    display.display();


    // =================================================
    // MLX90614
    // =================================================

    if (!mlx.begin())
    {
        Serial.println(
            "MLX90614 not found!"
        );


        display.clearDisplay();

        display.setCursor(0, 0);

        display.println(
            "MLX90614 ERROR"
        );

        display.println();

        display.println(
            "Check wiring"
        );

        display.display();


        while (true)
        {
            beep(100);

            delay(2000);
        }
    }


    Serial.println(
        "MLX90614 OK"
    );


    // =================================================
    // MAX30102
    // =================================================

    if (
        !particleSensor.begin(
            Wire,
            I2C_SPEED_FAST
        )
    )
    {
        Serial.println(
            "MAX30102 not found!"
        );


        display.clearDisplay();

        display.setCursor(0, 0);

        display.println(
            "MAX30102 ERROR"
        );

        display.println();

        display.println(
            "Check wiring"
        );

        display.display();


        while (true)
        {
            beep(100);

            delay(2000);
        }
    }


    Serial.println(
        "MAX30102 OK"
    );


    // =================================================
    // MAX30102 CONFIGURATION
    // =================================================

    byte ledBrightness = 60;

    byte sampleAverage = 4;

    byte ledMode = 2;

    int sampleRate = 100;

    int pulseWidth = 411;

    int adcRange = 4096;


    particleSensor.setup(
        ledBrightness,
        sampleAverage,
        ledMode,
        sampleRate,
        pulseWidth,
        adcRange
    );


    // =================================================
    // WIFI
    // =================================================

    setupWiFi();


    // =================================================
    // LOAD SAVED DEVICE TOKEN
    // =================================================

    loadDeviceToken();


    // =================================================
    // DEVICE REGISTRATION
    // =================================================

    if (!deviceRegistered)
    {
        Serial.println();
        Serial.println(
            "Device is NOT registered."
        );

        Serial.println(
            "Starting registration mode..."
        );


        generatePairingCode();

        displayPairingCode();


        // Immediately tell Laravel
        sendPairingRequest();
    }
    else
    {
        Serial.println();
        Serial.println(
            "Device already registered."
        );

        Serial.print(
            "Device UID: "
        );

        Serial.println(
            DEVICE_UID
        );


        display.clearDisplay();

        display.setTextSize(1);

        display.setCursor(0, 0);

        display.println(
            "Smart Health IoT"
        );

        display.println();

        display.println(
            "Device:"
        );

        display.println(
            DEVICE_UID
        );

        display.println();

        display.println(
            "Ready"
        );

        display.display();


        beep(100);

        delay(100);

        beep(100);

        delay(1000);
    }
}


// =====================================================
// WIFI MANAGER
// =====================================================

void setupWiFi()
{
    WiFiManager wifiManager;


    display.clearDisplay();

    display.setTextSize(1);

    display.setCursor(0, 0);

    display.println(
        "WiFi setup..."
    );

    display.println();

    display.println(
        "Connect to:"
    );

    display.println(
        "SmartHealth-ESP32"
    );

    display.display();


    Serial.println(
        "Starting WiFiManager"
    );


    bool connected =
        wifiManager.autoConnect(
            "SmartHealth-ESP32",
            "12345678"
        );


    if (!connected)
    {
        Serial.println(
            "WiFi connection failed"
        );


        display.clearDisplay();

        display.setCursor(0, 0);

        display.println(
            "WiFi Failed"
        );

        display.display();


        delay(3000);

        ESP.restart();
    }


    Serial.println(
        "WiFi connected"
    );


    Serial.print(
        "IP: "
    );

    Serial.println(
        WiFi.localIP()
    );


    display.clearDisplay();

    display.setCursor(0, 0);

    display.println(
        "WiFi Connected"
    );

    display.println();

    display.print(
        "IP:"
    );

    display.println(
        WiFi.localIP()
    );

    display.display();


    delay(2000);
}


// =====================================================
// LOAD DEVICE TOKEN
// =====================================================

void loadDeviceToken()
{
    preferences.begin(
        "smarthealth",
        false
    );


    deviceToken =
        preferences.getString(
            "token",
            ""
        );


    if (
        deviceToken.length() > 0
    )
    {
        deviceRegistered = true;


        Serial.println();
        Serial.println(
            "Saved device token found."
        );

        Serial.println(
            "Device is already registered."
        );
    }
    else
    {
        deviceRegistered = false;


        Serial.println();
        Serial.println(
            "No device token found."
        );

        Serial.println(
            "Device requires registration."
        );
    }
}


// =====================================================
// SAVE DEVICE TOKEN
// =====================================================

void saveDeviceToken(
    String token
)
{
    if (
        token.length() == 0
    )
    {
        Serial.println(
            "ERROR: Empty token."
        );

        return;
    }


    preferences.putString(
        "token",
        token
    );


    deviceToken =
        token;


    deviceRegistered = true;


    Serial.println();
    Serial.println(
        "================================="
    );

    Serial.println(
        " DEVICE TOKEN SAVED"
    );

    Serial.println(
        "================================="
    );
}


// =====================================================
// GENERATE PAIRING CODE
// =====================================================

void generatePairingCode()
{
    randomSeed(
        micros() ^
        analogRead(0) ^
        millis()
    );


    int code =
        random(
            100000,
            1000000
        );


    pairingCode =
        String(code);


    Serial.println();
    Serial.println(
        "================================="
    );

    Serial.println(
        " DEVICE REGISTRATION"
    );

    Serial.println(
        "================================="
    );


    Serial.print(
        "Device UID: "
    );

    Serial.println(
        DEVICE_UID
    );


    Serial.print(
        "Pairing Code: "
    );

    Serial.println(
        pairingCode
    );


    Serial.println(
        "================================="
    );
}


// =====================================================
// OLED PAIRING CODE
// =====================================================

void displayPairingCode()
{
    display.clearDisplay();

    display.setTextColor(
        SSD1306_WHITE
    );


    display.setTextSize(1);

    display.setCursor(0, 0);

    display.println(
        "Smart Health IoT"
    );


    display.println();

    display.println(
        "Register Device"
    );


    display.println();

    display.println(
        "Enter this code:"
    );


    display.setTextSize(2);

    display.setCursor(
        10,
        43
    );

    display.println(
        pairingCode
    );


    display.display();
}


// =====================================================
// OLED WAITING SCREEN
// =====================================================

void displayWaitingForRegistration()
{
    display.clearDisplay();

    display.setTextColor(
        SSD1306_WHITE
    );


    display.setTextSize(1);

    display.setCursor(0, 0);

    display.println(
        "Smart Health IoT"
    );


    display.println();

    display.println(
        "Waiting for"
    );

    display.println(
        "registration..."
    );


    display.println();

    display.print(
        "Code: "
    );

    display.println(
        pairingCode
    );


    display.display();
}


// =====================================================
// SEND PAIRING REQUEST
// =====================================================

bool sendPairingRequest()
{
    if (
        WiFi.status() !=
        WL_CONNECTED
    )
    {
        Serial.println(
            "WiFi not connected."
        );

        return false;
    }


    HTTPClient http;


    http.begin(
        PAIR_REQUEST_URL
    );


    http.addHeader(
        "Content-Type",
        "application/json"
    );


    String json = "{";


    json +=
        "\"device_uid\":\"";

    json +=
        DEVICE_UID;

    json +=
        "\",";


    json +=
        "\"pairing_code\":\"";

    json +=
        pairingCode;

    json +=
        "\"";


    json += "}";


    Serial.println();
    Serial.println(
        "Sending pairing request..."
    );


    Serial.println(
        json
    );


    int httpCode =
        http.POST(
            json
        );


    Serial.print(
        "Pair request HTTP: "
    );

    Serial.println(
        httpCode
    );


    if (
        httpCode > 0
    )
    {
        String response =
            http.getString();


        Serial.println(
            "Laravel response:"
        );

        Serial.println(
            response
        );


        if (
            httpCode >= 200 &&
            httpCode < 300
        )
        {
            pairingRequested =
                true;


            displayWaitingForRegistration();

            http.end();

            return true;
        }
    }


    Serial.println(
        "Pairing request failed."
    );


    http.end();


    return false;
}


// =====================================================
// CHECK PAIRING STATUS
// =====================================================

bool checkPairingStatus()
{
    if (
        WiFi.status() !=
        WL_CONNECTED
    )
    {
        return false;
    }


    HTTPClient http;


    String url =
        String(
            PAIR_STATUS_URL
        );


    url +=
        "?device_uid=";

    url +=
        DEVICE_UID;


    url +=
        "&pairing_code=";

    url +=
        pairingCode;


    Serial.println();
    Serial.println(
        "Checking pairing status..."
    );


    http.begin(
        url
    );


    int httpCode =
        http.GET();


    Serial.print(
        "Pair status HTTP: "
    );

    Serial.println(
        httpCode
    );


    if (
        httpCode <= 0
    )
    {
        http.end();

        return false;
    }


    String response =
        http.getString();


    Serial.println(
        "Laravel response:"
    );

    Serial.println(
        response
    );


    // =================================================
    // LOOK FOR:
    //
    // "paired":true
    // =================================================

    if (
        response.indexOf(
            "\"paired\":true"
        ) < 0
    )
    {
        http.end();

        return false;
    }


    // =================================================
    // FIND DEVICE TOKEN
    // =================================================

    String tokenKey =
        "\"device_token\":\"";


    int tokenStart =
        response.indexOf(
            tokenKey
        );


    if (
        tokenStart < 0
    )
    {
        Serial.println(
            "Pairing approved but token missing."
        );


        http.end();

        return false;
    }


    tokenStart +=
        tokenKey.length();


    int tokenEnd =
        response.indexOf(
            "\"",
            tokenStart
        );


    if (
        tokenEnd <= tokenStart
    )
    {
        Serial.println(
            "Invalid token response."
        );


        http.end();

        return false;
    }


    String token =
        response.substring(
            tokenStart,
            tokenEnd
        );


    if (
        token.length() == 0
    )
    {
        http.end();

        return false;
    }


    // =================================================
    // SAVE TOKEN
    // =================================================

    saveDeviceToken(
        token
    );


    http.end();


    return true;
}


// =====================================================
// HANDLE REGISTRATION
// =====================================================

void handleRegistration()
{
    if (
        deviceRegistered
    )
    {
        return;
    }


    unsigned long now =
        millis();


    // =================================================
    // RETRY PAIRING REQUEST
    // =================================================

    if (
        !pairingRequested
    )
    {
        if (
            now -
            lastPairingRequest >=
            PAIR_REQUEST_INTERVAL
        )
        {
            lastPairingRequest =
                now;


            displayPairingCode();


            sendPairingRequest();
        }


        return;
    }


    // =================================================
    // CHECK PAIRING STATUS
    // =================================================

    if (
        now -
        lastPairingCheck >=
        PAIR_STATUS_INTERVAL
    )
    {
        lastPairingCheck =
            now;


        if (
            checkPairingStatus()
        )
        {
            Serial.println();
            Serial.println(
                "================================="
            );

            Serial.println(
                " DEVICE REGISTERED!"
            );

            Serial.println(
                "================================="
            );


            display.clearDisplay();

            display.setTextSize(1);

            display.setCursor(0, 0);

            display.println(
                "Smart Health IoT"
            );

            display.println();

            display.println(
                "Device Registered!"
            );

            display.println();

            display.println(
                DEVICE_UID
            );

            display.println();

            display.println(
                "Ready!"
            );

            display.display();


            beep(100);

            delay(100);

            beep(100);

            delay(2000);


            // Reset timers
            lastApiSend =
                millis();

            lastSpO2Calculation =
                millis();
        }
        else
        {
            displayWaitingForRegistration();
        }
    }
}


// =====================================================
// MAIN LOOP
// =====================================================

void loop()
{
    // =================================================
    // REGISTRATION MODE
    // =================================================

    if (
        !deviceRegistered
    )
    {
        handleRegistration();

        delay(20);

        return;
    }


    // =================================================
    // NORMAL OPERATION
    // =================================================

    readSensors();


    // =================================================
    // SPO2 CALCULATION
    // =================================================

    if (
        millis() -
        lastSpO2Calculation >=
        SPO2_INTERVAL
    )
    {
        lastSpO2Calculation =
            millis();


        calculateSpO2();
    }


    // =================================================
    // OLED
    // =================================================

    updateDisplay();


    // =================================================
    // ALERTS
    // =================================================

    checkAlerts();


    // =================================================
    // SEND TO LARAVEL
    // =================================================

    if (
        millis() -
        lastApiSend >=
        API_INTERVAL
    )
    {
        lastApiSend =
            millis();


        sendToLaravel();
    }


    delay(20);
}


// =====================================================
// READ SENSORS
// =====================================================

void readSensors()
{
    // =================================================
    // MLX90614
    // =================================================

    bodyTemperature =
        mlx.readObjectTempC();


    ambientTemperature =
        mlx.readAmbientTempC();


    // =================================================
    // MAX30102
    // =================================================

    long irValue =
        particleSensor.getIR();


    // =================================================
    // FINGER DETECTION
    // =================================================

    if (
        irValue > 50000
    )
    {
        if (
            checkForBeat(
                irValue
            )
        )
        {
            long delta =
                millis() -
                lastBeat;


            lastBeat =
                millis();


            beatsPerMinute =
                60 /
                (
                    delta /
                    1000.0
                );


            if (
                beatsPerMinute > 20 &&
                beatsPerMinute < 255
            )
            {
                rates[
                    rateSpot++
                ] =
                    (byte)
                    beatsPerMinute;


                rateSpot %=
                    RATE_SIZE;


                beatAvg =
                    0;


                for (
                    byte x = 0;
                    x < RATE_SIZE;
                    x++
                )
                {
                    beatAvg +=
                        rates[x];
                }


                beatAvg /=
                    RATE_SIZE;
            }


            // Heartbeat beep
            beep(30);
        }
    }
    else
    {
        beatAvg = 0;
    }
}


// =====================================================
// SPO2 MEASUREMENT
// =====================================================

void calculateSpO2()
{
    bufferLength =
        100;


    Serial.println();

    Serial.println(
        "Calculating SpO2..."
    );


    // =================================================
    // COLLECT 100 SAMPLES
    // =================================================

    for (
        byte i = 0;
        i < bufferLength;
        i++
    )
    {
        while (
            particleSensor.available()
            == false
        )
        {
            particleSensor.check();
        }


        redBuffer[i] =
            particleSensor.getRed();


        irBuffer[i] =
            particleSensor.getIR();


        particleSensor.nextSample();
    }


    // =================================================
    // CALCULATE
    // =================================================

    maxim_heart_rate_and_oxygen_saturation(
        irBuffer,
        bufferLength,
        redBuffer,
        &spo2,
        &validSPO2,
        &heartRate,
        &validHeartRate
    );


    // =================================================
    // VALIDATE SPO2
    // =================================================

    if (
        !validSPO2
    )
    {
        spo2 = 0;
    }


    // =================================================
    // VALIDATE HEART RATE
    // =================================================

    if (
        !validHeartRate
    )
    {
        heartRate = 0;
    }


    if (
        validHeartRate
    )
    {
        beatAvg =
            heartRate;
    }


    Serial.print(
        "SpO2: "
    );

    Serial.println(
        spo2
    );


    Serial.print(
        "Heart Rate: "
    );

    Serial.println(
        beatAvg
    );
}


// =====================================================
// OLED DISPLAY
// =====================================================

void updateDisplay()
{
    display.clearDisplay();

    display.setTextColor(
        SSD1306_WHITE
    );


    // =================================================
    // HEART RATE
    // =================================================

    display.setTextSize(2);

    display.setCursor(
        0,
        0
    );


    display.print(
        "HR:"
    );


    if (
        beatAvg > 0
    )
    {
        display.print(
            beatAvg
        );
    }
    else
    {
        display.print(
            "--"
        );
    }


    display.setTextSize(1);

    display.print(
        " BPM"
    );


    // =================================================
    // SPO2
    // =================================================

    display.setCursor(
        0,
        20
    );


    display.setTextSize(2);

    display.print(
        "O2:"
    );


    if (
        spo2 > 0
    )
    {
        display.print(
            spo2
        );
    }
    else
    {
        display.print(
            "--"
        );
    }


    display.print(
        "%"
    );


    // =================================================
    // BODY TEMPERATURE
    // =================================================

    display.setCursor(
        0,
        40
    );


    display.setTextSize(1);

    display.print(
        "Body: "
    );


    display.print(
        bodyTemperature,
        1
    );


    display.print(
        " C"
    );


    // =================================================
    // AMBIENT TEMPERATURE
    // =================================================

    display.setCursor(
        0,
        52
    );


    display.print(
        "Room: "
    );


    display.print(
        ambientTemperature,
        1
    );


    display.print(
        " C"
    );


    display.display();
}


// =====================================================
// BUZZER ALERTS
// =====================================================

void checkAlerts()
{
    // =================================================
    // HIGH HEART RATE
    // =================================================

    if (
        beatAvg > 120
    )
    {
        alertBeep();
    }


    // =================================================
    // LOW SPO2
    // =================================================

    if (
        spo2 > 0 &&
        spo2 < 92
    )
    {
        alertBeep();
    }


    // =================================================
    // HIGH TEMPERATURE
    // =================================================

    if (
        bodyTemperature > 38.0
    )
    {
        alertBeep();
    }
}


// =====================================================
// SEND SENSOR DATA TO LARAVEL
// =====================================================

void sendToLaravel()
{
    if (
        WiFi.status() !=
        WL_CONNECTED
    )
    {
        Serial.println(
            "WiFi disconnected."
        );

        return;
    }


    if (
        !deviceRegistered
    )
    {
        Serial.println(
            "Device not registered."
        );

        return;
    }


    HTTPClient http;


    Serial.println();
    Serial.println(
        "Sending data to Laravel..."
    );


    // =================================================
    // API URL
    // =================================================

    http.begin(
        READINGS_URL
    );


    // =================================================
    // HEADERS
    // =================================================

    http.addHeader(
        "Content-Type",
        "application/json"
    );


    http.addHeader(
        "Authorization",
        String("Bearer ") +
        deviceToken
    );


    // =================================================
    // JSON
    // =================================================

    String json = "{";


    // Heart rate
    json +=
        "\"heart_rate\":";

    json +=
        String(
            beatAvg
        );


    json += ",";


    // SpO2
    json +=
        "\"spo2\":";

    json +=
        String(
            spo2
        );


    json += ",";


    // Body temperature
    json +=
        "\"body_temperature\":";

    json +=
        String(
            bodyTemperature,
            2
        );


    json += ",";


    // Ambient temperature
    json +=
        "\"ambient_temperature\":";

    json +=
        String(
            ambientTemperature,
            2
        );


    json += ",";


    // Battery
    json +=
        "\"battery_level\":";

    json +=
        String(
            batteryLevel
        );


    json += "}";


    Serial.println(
        "JSON:"
    );

    Serial.println(
        json
    );


    // =================================================
    // POST
    // =================================================

    int httpCode =
        http.POST(
            json
        );


    Serial.print(
        "HTTP Code: "
    );

    Serial.println(
        httpCode
    );


    // =================================================
    // RESPONSE
    // =================================================

    if (
        httpCode > 0
    )
    {
        String response =
            http.getString();


        Serial.println(
            "Laravel response:"
        );

        Serial.println(
            response
        );


        // ---------------------------------------------
        // Token rejected
        // ---------------------------------------------

        if (
            httpCode == 401 ||
            httpCode == 403
        )
        {
            Serial.println();
            Serial.println(
                "DEVICE TOKEN REJECTED!"
            );


            Serial.println(
                "Device must be registered again."
            );


            // Remove saved token
            preferences.remove(
                "token"
            );


            deviceToken =
                "";


            deviceRegistered =
                false;


            pairingRequested =
                false;


            generatePairingCode();


            displayPairingCode();


            sendPairingRequest();
        }
    }
    else
    {
        Serial.println(
            "Failed to connect to Laravel."
        );
    }


    http.end();
}


// =====================================================
// NORMAL BEEP
// =====================================================

void beep(
    int duration
)
{
    digitalWrite(
        BUZZER_PIN,
        HIGH
    );


    delay(
        duration
    );


    digitalWrite(
        BUZZER_PIN,
        LOW
    );
}


// =====================================================
// ALERT BEEP
// =====================================================

void alertBeep()
{
    beep(100);

    delay(100);

    beep(100);
}