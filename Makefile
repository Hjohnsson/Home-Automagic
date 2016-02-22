all: send codesend RFSniffer RFpi

send: RCSwitch.o send.o
	$(CXX) $(CXXFLAGS) $(LDFLAGS) $+ -o $@ -lwiringPi
	
codesend: RCSwitch.o codesend.o
	$(CXX) $(CXXFLAGS) $(LDFLAGS) $+ -o $@ -lwiringPi
	
RFSniffer: RCSwitch.o RFSniffer.o
	$(CXX) $(CXXFLAGS) $(LDFLAGS) $+ -o $@ -lwiringPi
	
RFpi: RCSwitch.o RFpi.o wiringPi.h
	$(CXX) $(CXXFLAGS) $(LDFLAGS) $+ -o $@ -lwiringPi

clean:
	$(RM) *.o send codesend servo RFSniffer RFpi
