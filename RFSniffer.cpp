/*
  RF_Sniffer
  
  Hacked from http://code.google.com/p/rc-switch/
  
  by @justy to provide a handy RF code sniffer
*/

#include "RCSwitch.h"
#include <stdlib.h>
#include <stdio.h>
     
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
          ofstream myfile;
          myfile.open("test.txt",std::ios_base::app);
          text = mySwitch.getReceivedValue();
          myfile << text;
          myfile << "\n";
          myfile.close();
        }
    
        mySwitch.resetAvailable();
    
      }
      
  
  }

  exit(0);


}
