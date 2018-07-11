#include <SigFox.h>
#include <ArduinoLowPower.h>
#include <DHT.h>

// defines pins numbers
const int buttonPin = 3;      // Button pin
const int trigPin = 9;        // Ultrasonic sensor 
const int echoPin = 10;       // Ultrasonic sensor 

// Time
unsigned long startMilis = 0;
unsigned long currentMilis;

// defines variables 
long duration;
int distance;
int level;
float tempLevel = 0;
float totalLevel= 30.00; 
int buttonState = 0; 
int moilvl;
uint8_t payload[5];
DHT dht(2, DHT11);
int timeopen = 0;
int sen = 0;
int j=0;
boolean push = 1;

//*********************************************************************************
void setup() {
  Serial.begin(9600);

  if (!SigFox.begin()) {
    Serial.println("Shield error or not present!");
    return;
  }
  // Enable debug led and disable automatic deep sleep
  SigFox.debug();
  delay(100);
  
  // Send the module to the deepest sleep
  SigFox.end();
  
  dht.begin();
  pinMode(buttonPin, INPUT);    // initialize the pushbutton pin as an input
  pinMode(trigPin, OUTPUT);     // Sets the trigPin as an Output
  pinMode(echoPin, INPUT);      // Sets the echoPin as an Input
}
//*********************************************************************************
void loop(){
  // read the state of the pushbutton value:
  buttonState = digitalRead(buttonPin);
  //Serial.print(String(buttonState)+ "\n");

  int sensorReading = analogRead(A0); // Flame sensor
  int fire = map(sensorReading, 0, 1024, 1, 4); //1 = Fire, 2 = Maybe Fire, 3 = No Fire
  if((fire == 1) || (fire == 2))
    {
    payload[0] = uint8_t(fire);
    Serial.print("Fire = " + String(payload[0]) + "\n");
    sendPayload(payload, 1); 
    j = 1;
    }
   else if((fire == 3) && (j==1))
   {
    payload[0] = uint8_t(fire);
    Serial.print("Fire = " + String(payload[0]) + "\n");
    sendPayload(payload, 1);
    j = 0;
    }

  // Send the data on schedule
  Serial.print("Period : " + String((currentMilis-startMilis)/1000)+ "\n");
  currentMilis = millis();
  if(currentMilis-startMilis >= 30000)  // Set the time schedule
   {
   startMilis = millis();
   Serial.print("Ready to send\n");
   sen = 1;       // Ready to send value
   }

  // check if the pushbutton pressed.
  if (buttonState == HIGH) {
    if(push == 0) // If the been previously closed
      {
      push = 1; // Set that bin is open
      timeopen++;  // Count Time open
      Serial.print("Time Open---------- " + String(timeopen)+ "\n");
      }
    } 
  else{
    push = 0; // Set push value to count time open the bin
    if(sen == 1)
      {
      uint16_t temperature = dht.readTemperature(false); //false=Celsius, true=Farenheit
      uint16_t humidity = dht.readHumidity(false); //Read humidity values
      
      digitalWrite(trigPin, LOW); // Clears the trigPin
      digitalWrite(trigPin, HIGH); // Sets the trigPin on HIGH state for 10 micro seconds
      delay(10);
      digitalWrite(trigPin, LOW);
      duration = pulseIn(echoPin, HIGH); // Reads the echoPin
      // Calculate the distance (Garbage in the bin)
      distance = duration*0.034/2; 
      if(distance > 30){
        distance = 30;}
      else if(distance < 0){
        distance = 0;}
      //Calculate level of garbage in %
      tempLevel = distance/totalLevel * 100;
      level = 100 - tempLevel;
      
      int moistureValue = analogRead(A1); // Moisture Value
      if(moistureValue < 250){ //Calculate Moisture Level
        moilvl = 1;}
      else if(moistureValue < 450){
        moilvl = 2;}
      else if(moistureValue < 600){
        moilvl = 3;}
      else if(moistureValue < 800){
        moilvl = 4;}
      else if(moistureValue < 1000){ 
        moilvl = 5;}
      else{
        moilvl = 6;}

      Serial.print("Time Open in hr ****** " + String(timeopen)+ " ********\n");
     
      payload[0] = uint8_t(temperature + 50); //+50 to prevent less than 0
      payload[1] = uint8_t(humidity);
      payload[2] = uint8_t(level);
      payload[3] = uint8_t(moilvl);
      payload[4] = uint8_t(timeopen);
      sendPayload(payload, 5);
      
      timeopen = 0; // Reset number of time open the bin in this hour
      sen = 0;      // Set send value to 0 to wait for another hour to send again
      }
    }
    delay(500);
  }
//*********************************************************************************
void sendPayload(uint8_t pyl[], int size) {
  SigFox.begin(); // Start the module
  delay(100); // Wait at least 30mS after first configuration (100mS before)
  SigFox.status(); // Clears all pending interrupts
  delay(1);

  SigFox.beginPacket(); // Begin to send packet
  for (int i = 0; i < size;i++) {
    SigFox.write(pyl[i]);}

  int ret = SigFox.endPacket();  // send buffer to SIGFOX network
  if (ret > 0) {
    Serial.println("No transmission");} 
  else {
    Serial.println("Transmission ok");}

  Serial.println(SigFox.status(SIGFOX));
  Serial.println(SigFox.status(ATMEL));
  SigFox.end();
}
