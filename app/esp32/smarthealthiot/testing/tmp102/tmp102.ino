#include <Wire.h>

#define SDA_PIN 21
#define SCL_PIN 22

#define TMP102_ADDR 0x48
#define TEMP_REGISTER 0x00

void setup()
{
  Serial.begin(115200);

  Wire.begin(SDA_PIN, SCL_PIN);

  Serial.println("ESP32 + TMP102");
  Serial.println("----------------");

  // Check if TMP102 is connected
  Wire.beginTransmission(TMP102_ADDR);

  if (Wire.endTransmission() == 0)
  {
    Serial.println("TMP102 detected!");
  }
  else
  {
    Serial.println("TMP102 NOT detected!");
  }
}

void loop()
{
  float temperature = readTMP102();

  if (temperature != -999)
  {
    Serial.print("Ambient Temperature: ");
    Serial.print(temperature, 2);
    Serial.println(" °C");
  }
  else
  {
    Serial.println("Error reading TMP102");
  }

  delay(1000);
}

float readTMP102()
{
  // Select temperature register
  Wire.beginTransmission(TMP102_ADDR);
  Wire.write(TEMP_REGISTER);

  if (Wire.endTransmission(false) != 0)
  {
    return -999;
  }

  // Request 2 bytes
  Wire.requestFrom(TMP102_ADDR, 2);

  if (Wire.available() < 2)
  {
    return -999;
  }

  uint8_t msb = Wire.read();
  uint8_t lsb = Wire.read();

  // TMP102 temperature is 12-bit by default
  int16_t raw = ((msb << 8) | lsb);

  raw >>= 4;

  // Handle negative temperatures
  if (raw & 0x800)
  {
    raw |= 0xF000;
  }

  float temperature = raw * 0.0625;

  return temperature;
}
