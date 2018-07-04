#include <SigFox.h>
#include <ArduinoLowPower.h>
#include <DHT.h>

// defines pins numbers
const int buttonPin = 3;      // the number of the pushbutton pin
//const int ledPin =  13;       // the number of the LED pin for button status (Data sending)
const int trigPin = 9;        // ultrasonic sensor 
const int echoPin = 10;       // ultrasonic sensor 

// lowest and highest sensor readings for flame sensor:
const int sensorMin = 0;     // sensor minimum
const int sensorMax = 1024;  // sensor maximum

// defines variables 
long duration;
int distance;
int level;
float tempLevel = 0;
float totalLevel= 30.00; 
int buttonState = 0; 
int moilvl;
DHT dht(2, DHT11);
 

//*********************************************************************************
void setup() {
  Serial.begin(9600);
//  while (!Serial) {};

  // Uncomment this line and comment begin() if you are working with a custom board
  //if (!SigFox.begin(SPI1, 30, 31, 33, 28, LED_BUILTIN)) {
  if (!SigFox.begin()) {
    Serial.println("Shield error or not present!");
    return;
  }
  // Enable debug led and disable automatic deep sleep
  // Comment this line when shipping your project 🙂
  SigFox.debug();

  // Display module informations
  // Serial.print("Module temperature: ");
  // Serial.println(SigFox.internalTemperature());
  
  delay(100);

  // Send the module to the deepest sleep
  SigFox.end();

//  //Serial.println("hello world");
//  while (!Serial.available());
//
//  String message;
//  while (Serial.available()) {
//    message += (char)Serial.read();
//  }

  dht.begin();

  //pinMode(ledPin, OUTPUT);      // initialize the LED pin as an output
  pinMode(buttonPin, INPUT);    // initialize the pushbutton pin as an input

  pinMode(trigPin, OUTPUT);     // Sets the trigPin as an Output
  pinMode(echoPin, INPUT);      // Sets the echoPin as an Input

  //pinMode(outputA, INPUT);
  //pinMode(outputB, INPUT);

  //aLastState = digitalRead(outputA);

  // Every SigFox packet cannot exceed 12 bytes
  // If the string is longer, only the first 12 bytes will be sent
  //if (payload.length() > 12) {
  //    Serial.println("Message too long, only first 12 bytes will be sent");
  //  }

  // Remove EOL (End of line)
  // message.trim();
  
  // Example of message that can be sent
  //sendString(payload);
}


  

//*********************************************************************************
void loop()
  {
  // read the state of the pushbutton value:
  buttonState = digitalRead(buttonPin);
  Serial.print("Begin-----------------------------------------------------------\n");
  // check if the pushbutton is pressed. If it is, the buttonState is HIGH:
  if (buttonState == LOW) 
    {
    //digitalWrite(ledPin, LOW);  // turn LED off
    } 
  else if (buttonState == HIGH) 
    {
    //digitalWrite(ledPin, HIGH); // turn LED on

    // Read sensor values and multiply by 100 to effictively have 2 decimals
    uint16_t humidity = dht.readHumidity(false);
  
    // false: Celsius (default)
    // true: Farenheit
    uint16_t temperature = dht.readTemperature(false); 

    digitalWrite(trigPin, LOW); // Clears the trigPin
  
    // Sets the trigPin on HIGH state for 10 micro seconds
    digitalWrite(trigPin, HIGH);
    delay(10);
    digitalWrite(trigPin, LOW);
  
    // Reads the echoPin, returns the sound wave travel time in microseconds
    duration = pulseIn(echoPin, HIGH);
  
    // Calculating the distance (level)
    distance = duration*0.034/2;
     if (distance > 30)
     {
      distance = 30;
     }
     else if (distance < 0)
     {
      distance = 0;
     }
    
    //Calculate level of garbage in %
    tempLevel = distance/totalLevel * 100;
    level = 100 - tempLevel;

    // Moisture Value+++++++++++++++++++++++++++++++
    int moistureValue = analogRead(A1);

    //Calculate Moisture Level
    if(moistureValue < 250)
      {
      moilvl = 1;
      }
    else if(moistureValue < 450)
      {
      moilvl = 2;
      }
    else if(moistureValue < 600)
      {
      moilvl = 3;
      }
    else if(moistureValue < 800)
      {
      moilvl = 4;
      }
    else if(moistureValue < 1000)
      {
      moilvl = 5;
      }
    else
      {
      moilvl = 6;
      }
    
    // Flame sensor
    // read the sensor on analog A0:
    int sensorReading = analogRead(A0);
    // map the sensor fire (four options):
    //0 = A fire closer than 1.5 feet away.
    //1 = A fire between 1-3 feet away.
    //2 = No fire detected.
    int fire = map(sensorReading, sensorMin, sensorMax, 1, 4);
    

    uint8_t payload[5];
    payload[0] = uint8_t(temperature + 50); //+50 to prevent less than 0
    payload[1] = uint8_t(humidity);
    payload[2] = uint8_t(level);
    payload[3] = uint8_t(fire);
    payload[4] = uint8_t(moilvl);
    //sendPayload(payload, 5);
    
    //Serial.println(a);
    Serial.print("Temperature: " + String(temperature) + "+50\n");
    Serial.print("Humidity: " + String(humidity) + "\n");
    Serial.print("distance (cm): " + String(distance) + "\n");
    Serial.print("Level (%): " + String(level) + "\n");
    Serial.print("Fire : " + String(fire) + "\n");
    Serial.print("Moisture Value: " + String(moistureValue) + "\n");
    Serial.print("Moisture (LV): " + String(moilvl) + "\n");
    
//    switch (fire) {
//    case 0:
//      Serial.print("A fire closer than 1.5 feet away.\n");
//      break;
//    case 1:
//      Serial.print("A fire between 1-3 feet away.\n");
//      break;
//    case 2:
//      Serial.print("No fire detected.\n");   
//      break;
//    }
    
    
     //sendPayload(payload);
    }
    delay(1000);
    //Serial.print("Going To Sleep!\n");
    //LowPower.sleep(15000);
    //Serial.print("Woke Up!\n");
  }

//*********************************************************************************

//*********************************************************************************
void sendPayload(uint8_t pyl[], int size) {
  // Start the module
  SigFox.begin();
  // Wait at least 30mS after first configuration (100mS before)
  delay(100);
  // Clears all pending interrupts
  SigFox.status();
  delay(1);
  
  SigFox.beginPacket();
  for (int i = 0; i < size;i++) 
    {
    SigFox.write(pyl[i]);
    }

  int ret = SigFox.endPacket();  // send buffer to SIGFOX network
  if (ret > 0) 
    {
    Serial.println("No transmission");
    } 
  else 
    {
    Serial.println("Transmission ok");
    }
  Serial.println(SigFox.status(SIGFOX));
  Serial.println(SigFox.status(ATMEL));
  SigFox.end();
}


//*********************************************************************************
//void sendStringAndGetResponse(String str) {
//  // Start the module
//  SigFox.begin();
//  // Wait at least 30mS after first configuration (100mS before)
//  delay(100);
//  // Clears all pending interrupts
//  SigFox.status();
//  delay(1);
//
//  SigFox.beginPacket();
//  SigFox.print(str);
//
//  int ret = SigFox.endPacket(true);  // send buffer to SIGFOX network and wait for a response
//  if (ret > 0) {
//    Serial.println("No transmission");
//  } else {
//    Serial.println("Transmission ok");
//  }
//
//  Serial.println(SigFox.status(SIGFOX));
//  Serial.println(SigFox.status(ATMEL));
//
//  if (SigFox.parsePacket()) {
//    Serial.println("Response from server:");
//    while (SigFox.available()) {
//      Serial.print("0x");
//      Serial.println(SigFox.read(), HEX);
//    }
//  } else {
//    Serial.println("Could not get any response from the server");
//    Serial.println("Check the SigFox coverage in your area");
//    Serial.println("If you are indoor, check the 20dB coverage or move near a window");
//  }
//  Serial.println();
//
//  SigFox.end();
//}
