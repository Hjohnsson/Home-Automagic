#include "DIST.h"
#include "RCSwitch.h"

RCSwitch mySwitch = RCSwitch();
DIST Dist = DIST(12,8);

int i = 0;
long dist = 0;
double procent = 0;

setup()
{
  //Dist DIST(12,8);
  Serial.begin(9600);
  mySwitch.enableTransmit(10);
}

void loop() 
{
    dist = Dist.Distance();
    if (dist<10 || dist>30) {
       procent = 0;
    } else {
    procent = (dist-10)/(20);
    }   

    mySwitch.send(dist, 24);
    delay(1000);
}
