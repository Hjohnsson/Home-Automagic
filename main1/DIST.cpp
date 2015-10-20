#include "Arduino.h"
#include "DIST.h"

DIST::DIST(int trigg_pin,int echo_pin)
{
  pinMode(trigg_pin,OUTPUT);
  pinMode(echo_pin,INPUT);
  _trigg_pin = trigg_pin;
  _echo_pin = echo_pin;
  _faktor = 17/850;
}
long DIST::Distance()
{
  long micro;
  long dist;
  digitalWrite(_trigg_pin, LOW);
  delayMicroseconds(2);
  digitalWrite(_trigg_pin, HIGH);
  delayMicroseconds(10);
  digitalWrite(_trigg_pin, LOW);
  micro = pulseIn(_echo_pin,HIGH);
  dist=micro*_faktor;
  return dist;
};

