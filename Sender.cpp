#include "Arduino.h"
#include "Sender.h"

Sender::Sender(int transmit_pin)
{
  _transmit_pin = transmit_pin;
}

//  setup sender
void setup() {
  mySwitch = RCSwitch();
     
  printf("Setup complete\n"); 
};

//  send message
bool sendMessage(long message, int send_bit_protocol) {
  if (isMessageCorrect(message)) {
    _message = message;
  } else {
    return false;
  }

  mySwitch.enableTransmit(_transmit_pin);
  mySwitch.send(_message, send_bit_protocol);      
  mySwitch.disableTransmit();

  return true;
};

//  control formatting of message
bool isMessageCorrect(long message) {
  return ( (message/10000000) == 1 );
};

//  sender ready?
bool isSenderReady() {

  return true;
};

//  get recent message sent
long getLastMessage() {
  return _message;
};

