#include <Wire.h>
#include "Protocentral_MAX30205.h"

MAX30205 tempSensor;

void setup() {
  Serial.begin(115200);
  Wire.begin();

  // Scan for the sensor at 0x48 / 0x49 until one is found
  while (!tempSensor.scanAvailableSensors()) {
    Serial.println("Couldn't find the temperature sensor, please connect the sensor.");
    delay(5000);
  }

  tempSensor.begin();   // Continuous conversion, active mode
}

void loop() {
  Serial.print(tempSensor.getTemperature(), 2);
  Serial.println(" C");
  delay(100);
}