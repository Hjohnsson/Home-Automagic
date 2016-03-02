#ifndef Sender_h
#define Sender_h

#include <RCSwitch.h>

class Sender
{
  public:
    Sender(int transmit_pin);
    //	send message
    bool sendMessage(long message, int send_bit_protocol);
    //	setup sender
    void setup();
    //	sender ready?
    bool isSenderReady();
    //	get recent message sent
    long getLastMessage();
 private:
    //  control formatting of message
    bool isMessageCorrect(long message);

    int _transmit_pin;
    long _message;
    RCSwitch _mySwitch;
};
#endif

