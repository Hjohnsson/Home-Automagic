all: RFpi

RFpi: RCSwitch.o RFpi.o wiringPi.h
	$(CXX) $(CXXFLAGS) $(LDFLAGS) $+ -o $@ -lwiringPi

clean:
	$(RM) *.o RFpi
