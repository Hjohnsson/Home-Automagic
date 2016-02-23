#include <stdio.h>
#include <wiringPi.h>

// LED Pin - wiringPi pin 2 is BCM_GPIO 27.

#define LED     2

int main (void)
{
  printf ("Raspberry Pi - Gertboard Blink\n") ;

  wiringPiSetup () ;

  pinMode (LED, OUTPUT) ;

  for (;;)
  {
    digitalWrite (LED, 1) ;     // On
    delay (500) ;               // mS
    digitalWrite (LED, 0) ;     // Off
    delay (500) ;
  }
  return 0 ;
}
