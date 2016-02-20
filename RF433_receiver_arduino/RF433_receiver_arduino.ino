#define rfReceivePin A0  //RF Receiver pin = Analog pin 0

unsigned int data = 0;   // variable used to store received data
const unsigned int upperThreshold = 70;//upper threshold value
const unsigned int lowerThreshold = 50;  //lower threshold value

void setup(){
  pinMode(7, OUTPUT);  // LED
  Serial.begin(9600);
}

void loop(){
  data=analogRead(rfReceivePin);    //listen for data on Analog pin 0

  if(data>upperThreshold){
    digitalWrite(7, LOW);   //If a LOW signal is received, turn LED OFF
    Serial.println(data);
  }

  if(data<lowerThreshold){
    digitalWrite(7, HIGH);   //If a HIGH signal is received, turn LED ON
    Serial.println(data);
  }
}

