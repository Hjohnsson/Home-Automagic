#ifndef PWM_MOD_h
#define PWM_MOD_h

#include "Arduino.h"

class PWM_MOD
{
  public:
    PWM_MOD(int pin);
    //PWM(int pin,int procent);
    void set_procent(double procent);
};
#endif
