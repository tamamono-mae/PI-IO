import time
import sys
import RPi.GPIO as GPIO
import pigpio

# Import SPI library (for hardware SPI) and MCP3008 library.
import Adafruit_GPIO.SPI as SPI
import Adafruit_MCP3008

#pi = pigpio.pi()

#Parameter
GPIO.setmode(GPIO.BCM) ## Use board pin numbering
GPIO.setwarnings(False)

src_unit = 'V'
# src_ref = 0.00967741935484
src_ref = float(input("Enter a number for Ref Voltage(mv): "))
src_ref = src_ref  * 0.001

# Hardware SPI configuration:
SPI_PORT   = 0
SPI_DEVICE = 0
mcp = Adafruit_MCP3008.MCP3008(spi=SPI.SpiDev(SPI_PORT, SPI_DEVICE))

def io_rst():
	GPIO.setup(23,GPIO.OUT)
	GPIO.setup(24,GPIO.OUT)
	GPIO.setup(25,GPIO.OUT)
	GPIO.output(23,GPIO.LOW)
	GPIO.output(24,GPIO.LOW)
	GPIO.output(25,GPIO.LOW)
	
def io_vw():
	GPIO.output(23,GPIO.LOW)
	GPIO.output(24,GPIO.HIGH)
	GPIO.output(25,GPIO.LOW)
	
def io_hw():
	GPIO.output(23,GPIO.LOW)
	GPIO.output(24,GPIO.LOW)
	GPIO.output(25,GPIO.HIGH)
	
def io_eq():
	GPIO.output(23,GPIO.HIGH)
	GPIO.output(24,GPIO.LOW)
	GPIO.output(25,GPIO.LOW)
	
io_rst()
print('Reading MCP3008 values, press Ctrl-C to quit...')
# Main program loop.
while True:
    # Read all the ADC channel values in a list.
    values = [0]*10
    for i in range(2):
        # The read_adc function will get the value of the specified channel (0-7).
        values[i] = mcp.read_adc(i) * src_ref / 1023
        #values[i] = int(input("Enter a numberfor V and H: "))
    # Print the ADC values.
    print('| {0:>4} | {1:>4} |'.format(*values))
    # Compare V and H
    if values[0] > values[1] :
    	io_vw()
    	print('V')
    elif values[0] < values[1] :
    	io_hw()
    	print('H')
    else:
    	io_eq()
    	print ('Equal')
    # Pause for half a second.
    time.sleep(0.5)
