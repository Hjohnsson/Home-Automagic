/*
  RF_Sniffer
  
  Hacked from http://code.google.com/p/rc-switch/
  
  by @justy to provide a handy RF code sniffer
*/

#include "RCSwitch.h"
#include <stdlib.h>
#include <stdio.h>
#include <wiringPi.h>
     
#include <iostream>
#include <fstream>

using namespace std;
     
RCSwitch mySwitch;
 
#define GREEN    2
#define YELLOW   4

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
          wiringPiSetup () ;
          pinMode (GREEN, OUTPUT) ;
          pinMode (YELLOW, OUTPUT) ;

          if (mySwitch.getReceivedValue() == 1001) {
            digitalWrite (GREEN, 1) ;     // On
            digitalWrite (YELLOW, 0) ;     // Off
          }
          if (mySwitch.getReceivedValue() == 1000) {
            digitalWrite (GREEN, 0) ;     // Off
            digitalWrite (YELLOW, 1) ;     // On
          }
        }
        mySwitch.resetAvailable();
    
      }
      
  
  }

  exit(0);


}

