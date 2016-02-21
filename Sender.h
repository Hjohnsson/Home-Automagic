#ifndef Sender_h
#define Sender_h

#include "Arduino.h"
#include "RCSwitch.h"

class Sender
{
  public:
    Sender(int sender_pin);

    //	send message
    bool sendMessage(long message, int send_bit_protocol);
    //	setup sender
    void setup();
    //	control formatting of message
    bool isMessageCorrect(long message);
    //	sender ready?
    bool isSenderReady();
    //	get recent message sent
    long getLastMessage();
 private:
    int _transmit_pin;
    long _message;
};
#endif

