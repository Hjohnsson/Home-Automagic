#include <RCSwitch.h>

RCSwitch mySwitch = RCSwitch();

int counter;

void setup() {
  // Output
  pinMode(10, OUTPUT);  // Pin 10 to drive the data pin of the transmitter.
  pinMode(13, OUTPUT);  // Internal LED
  pinMode(7, OUTPUT);   // Green -
  pinMode(6, OUTPUT);   // Red - 


  // Input
  pinMode(4, INPUT);    // Pushbutton ON/OFF

  Serial.begin(9600);

  // Transmitter is connected to Arduino Pin #10  
  mySwitch.enableTransmit(10);

}

void loop() {


  if (digitalRead(4) == true) {
    Serial.print("ON \n");

    if (counter == 1) {
      digitalWrite(7, HIGH);
      mySwitch.send(1001, 24);
      digitalWrite(7, LOW);
      delay(1000);
      counter = 0;
      Serial.print("Transmitting 1001 \n");
    }
    else if (counter == 0) {
      digitalWrite(7, HIGH);
      mySwitch.send(1000, 24);
      digitalWrite(7, LOW);
      delay(1000);
      counter = 1;
      Serial.print("Transmitting 1000 \n");
    }
  }
  else if (digitalRead(4) == false) {
    Serial.print("OFF \n");
    delay(1000);
  }
}




