#ifndef DIST_h
#define DIST_h

#include "Arduino.h"

class DIST
{
  public:
    DIST(int trigg_pin,int echo_pin);
    long Distance();
 private:
    int _trigg_pin;
    int _echo_pin;
    double _faktor;
};
#endif

