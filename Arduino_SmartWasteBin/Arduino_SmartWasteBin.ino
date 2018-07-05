#include <SigFox.h>
#include <ArduinoLowPower.h>
#include <DHT.h>

// defines pins numbers
const int buttonPin = 3;      // Button pin
const int trigPin = 9;        // Ultrasonic sensor 
const int echoPin = 10;       // Ultrasonic sensor 

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
  Serial.print(String(buttonState)+ "\n");
  // check if the pushbutton pressed.
  if (buttonState == HIGH) {} 
  else{
    uint16_t temperature = dht.readTemperature(false); //false=Celsius, true=Farenheit
    uint16_t humidity = dht.readHumidity(false); //Read humidity values
    
    digitalWrite(trigPin, LOW); // Clears the trigPin
    digitalWrite(trigPin, HIGH); // Sets the trigPin on HIGH state for 10 micro seconds
    delay(10);
    digitalWrite(trigPin, LOW);
    duration = pulseIn(echoPin, HIGH); // Reads the echoPin
    distance = duration*0.034/2; // Calculate the distance (Garbage in the bin)
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
    
    int sensorReading = analogRead(A0); // Flame sensor
    int fire = map(sensorReading, 0, 1024, 1, 4); //1 = Fire, 2 = Maybe Fire, 3 = No Fire

    uint8_t payload[5];
    payload[0] = uint8_t(temperature + 50); //+50 to prevent less than 0
    payload[1] = uint8_t(humidity);
    payload[2] = uint8_t(level);
    payload[3] = uint8_t(fire);
    payload[4] = uint8_t(moilvl);
    sendPayload(payload, 5);
    }
    delay(1000);
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
