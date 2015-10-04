#include "Arduino.h"
#include "PWM_MOD.h"

PWM_MOD::PWM_MOD(int pin)
{
  pinMode(pin, OUTPUT);
  TCCR2A = _BV(COM2A0) | _BV(COM2B1) | _BV(WGM21) | _BV(WGM20);
  TCCR2B = _BV(WGM22) | _BV(CS22);
  OCR2A = 0;
  OCR2B = 0;
}
void PWM_MOD::set_procent(double procent)
{
  int langd;
  langd = (int)(255*procent);
  OCR2A = langd;
};
