#include "RCSwitch.h"
#include <stdlib.h>
#include <stdio.h>
#include <wiringPi.h>
     
#include <iostream>
#include <fstream>

using namespace std;
     
RCSwitch mySwitch;

int text = 0;

int main(int argc, char *argv[]) {
  
     // This pin is not the first pin on the RPi GPIO header!
     // Consult https://projects.drogon.net/raspberry-pi/wiringpi/pins/
     // for more information.
     int PIN = 0;
     
     if(wiringPiSetup() == -1)
       return 0;

     mySwitch = RCSwitch();
     mySwitch.enableReceive(PIN);  // Receiver on inerrupt 0 => that is pin #2
     
    
     while(1) {
  
      if (mySwitch.available()) {
    
        int value = mySwitch.getReceivedValue();
    
        if (value == 0) {
          printf("Unknown encoding");
        } else {    
   
          printf("Received %i\n", mySwitch.getReceivedValue() );
        }
        mySwitch.resetAvailable();
    
      }
      
  
  }

  exit(0);


}

