#include <RCSwitch.h>

#define  RPI_ID     110
#define  ARD_ID     120
#define  FNK_ALIVE  1
#define  FNK_TEMP   2
#define  FNK_NEXA   3
#define  DATA_NULL  0
#define  SEND_BIT_PROTOCOL  24

RCSwitch mySwitch = RCSwitch();

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
  mySwitch.enableReceive(0);  // Receiver on inerrupt 0 => that is pin #2
  
}

void loop() {
    
  if (mySwitch.available()) {    
    long value = mySwitch.getReceivedValue();
    mySwitch.resetAvailable();
    delay(500);
    
    long mesgID = value / 100000;
    long mesgFNK = (value / 10000)%10;
    long mesgDATA = value % 10000;
    // Debug output.
   /* 
    Serial.print("Received: ");
    Serial.println(value);
    Serial.print("ID: ");
    Serial.println(mesgID);
    Serial.print("FNK: ");
    Serial.println(mesgFNK);
    Serial.print("DATA: ");
    Serial.println(mesgDATA);
    */
    if (mesgID == ARD_ID) {
      switch (mesgFNK) {
        case FNK_ALIVE:
          Serial.println("Keep alive message received!");
          Serial.println("--");
          Serial.println("Sending Keep alive");
          
          mySwitch.send(GenerateMessage(RPI_ID,FNK_ALIVE,DATA_NULL ), SEND_BIT_PROTOCOL);
          break;
        case FNK_TEMP:
          Serial.println("Temp message received!");
          break;
        case FNK_NEXA:
          Serial.println("Nexa message received!");
          break;  
      }
    }
  }
}

long GenerateMessage(int id, int fnk, int data) {
   return id * 100000 + fnk *10000 + data; 
}
