#include <Wire.h>
#include "MAX30105.h"
#include "spo2_algorithm.h"

MAX30105 particleSensor;

#define SDA_PIN 21
#define SCL_PIN 22

#define BUFFER_SIZE 100

uint32_t irBuffer[BUFFER_SIZE];
uint32_t redBuffer[BUFFER_SIZE];

int32_t spo2;
int8_t validSPO2;

int32_t heartRate;
int8_t validHeartRate;

void setup()
{
  Serial.begin(115200);
  delay(1000);

  Wire.begin(SDA_PIN, SCL_PIN);

  Serial.println("MAX30102 ESP32");
  Serial.println("----------------");

  if (!particleSensor.begin(Wire, I2C_SPEED_FAST))
  {
    Serial.println("MAX30102 not found!");
    Serial.println("Check wiring.");
    while (1);
  }

  Serial.println("MAX30102 detected!");

  // Sensor configuration
  byte ledBrightness = 60;
  byte sampleAverage = 4;
  byte ledMode = 2;       // Red + IR
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

  particleSensor.setPulseAmplitudeRed(0x3F);
  particleSensor.setPulseAmplitudeIR(0x3F);

  Serial.println();
  Serial.println("Place your finger on the sensor.");
}


void loop()
{
  // Collect 100 samples
  for (int i = 0; i < BUFFER_SIZE; i++)
  {
    while (particleSensor.available() == false)
    {
      particleSensor.check();
    }

    redBuffer[i] = particleSensor.getRed();
    irBuffer[i] = particleSensor.getIR();

    particleSensor.nextSample();
  }

  // Calculate BPM and SpO2
  maxim_heart_rate_and_oxygen_saturation(
    irBuffer,
    BUFFER_SIZE,
    redBuffer,
    &spo2,
    &validSPO2,
    &heartRate,
    &validHeartRate
  );

  Serial.println("---------------------------");

  // Check whether finger is present
  if (irBuffer[BUFFER_SIZE - 1] < 50000)
  {
    Serial.println("No finger detected");
    Serial.println("BPM  : --");
    Serial.println("SpO2 : --");
  }
  else
  {
    // BPM
    Serial.print("BPM  : ");

    if (validHeartRate)
    {
      Serial.println(heartRate);
    }
    else
    {
      Serial.println("--");
    }

    // SpO2
    Serial.print("SpO2 : ");

    if (validSPO2)
    {
      Serial.print(spo2);
      Serial.println(" %");
    }
    else
    {
      Serial.println("--");
    }
  }

  Serial.println("---------------------------");

  delay(500);
}