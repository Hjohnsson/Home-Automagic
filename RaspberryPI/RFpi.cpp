#include "RCSwitch.h"
#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include <time.h>
#include <sys/time.h>
     
#define  RPI_ID     110
#define  ARD_ID     120
#define  FNK_ALIVE  1
#define  FNK_TEMP   2
#define  FNK_NEXA   3
#define  DATA_NULL  0
#define  SEND_BIT_PROTOCOL  24
     
RCSwitch mySwitch;
 
void setup() {
    // Input
  int transmittPIN = 3;

    // Input
  int receivePIN = 0;

  mySwitch = RCSwitch();
     
  printf("Setup complete\n"); 
}


long GenerateMessage(int id, int fnk, int data) {
   return id * 100000 + fnk *10000 + data; 
}

int main() {
     printf("Started\n");
     if(wiringPiSetup() == -1)
        return 0;

     struct timeval tim;

     long tmp = 0;
     long value = 0;

     setup(); 
    
     while(true) {
  
      //usleep(1000000);
      printf("Sending keep alive message\n");
      //mySwitch.enableTransmit(3);
      //mySwitch.send(GenerateMessage(ARD_ID,FNK_ALIVE,DATA_NULL), SEND_BIT_PROTOCOL);      
      //mySwitch.disableTransmit();




      gettimeofday(&tim, NULL);

      double t1=tim.tv_sec+(tim.tv_usec/1000000.0);
      double t2=tim.tv_sec+(tim.tv_usec/1000000.0);

      value = 0;
      mySwitch.enableReceive(0);  // Receiver on inerrupt 0 => that is pin #2
      while(true) {
        tmp = mySwitch.getReceivedValue();
        mySwitch.disableReceive();  // Receiver on inerrupt 0 => that is pin #2

        if(tmp > 1) {
          value = tmp;
        }
        
        gettimeofday(&tim, NULL);
        t2=tim.tv_sec+(tim.tv_usec/1000000.0);
        //printf("%.6lf\n",(t2-t1));
        if( (t2-t1) >= 1 ) {
          printf("Timeout \n");
          break;
        } 
      }
      mySwitch.resetAvailable();

      if(value >= 0) {
         printf("%.6lf \n",value);
      }
  
  }

  exit(0);


}

