import sys
import RPi.GPIO as GPIO
import pigpio
global row_count
global col_count
global row_col_val

pi = pigpio.pi()

#Parameter
GPIO.setmode(GPIO.BCM) ## Use board pin numbering
GPIO.setwarnings(False)
row_count = 4
col_count = 4
input_len = len(sys.argv)

def check_input(input, limit):
	input_check = int(input)
	if input_check <= 0 :
		print('value too small')
		sys.exit()
	elif input_check > limit :
		print('value too big')
		sys.exit()

def io_rst():
	pi.set_mode(4, pigpio.OUTPUT)
	pi.set_mode(17, pigpio.OUTPUT)
	pi.set_mode(27, pigpio.OUTPUT)
	pi.set_mode(22, pigpio.OUTPUT)
	pi.set_mode(5, pigpio.OUTPUT)
	pi.set_mode(6, pigpio.OUTPUT)
	pi.set_mode(13, pigpio.OUTPUT)
	pi.set_mode(19, pigpio.OUTPUT)
	pi.set_mode(18, pigpio.OUTPUT)
	pi.set_mode(23, pigpio.OUTPUT)
	pi.set_mode(24, pigpio.OUTPUT)
	pi.set_mode(25, pigpio.OUTPUT)
	pi.set_mode(12, pigpio.OUTPUT)
	pi.set_mode(16, pigpio.OUTPUT)
	pi.set_mode(20, pigpio.OUTPUT)
	pi.set_mode(21, pigpio.OUTPUT)
	pi.write(4,False)
	pi.write(17,False)
	pi.write(27,False)
	pi.write(22,False)
	pi.write(5,False)
	pi.write(6,False)
	pi.write(13,False)
	pi.write(19,False)
	pi.write(18,False)
	pi.write(23,False)
	pi.write(24,False)
	pi.write(25,False)
	pi.write(12,False)
	pi.write(16,False)
	pi.write(20,False)
	pi.write(21,False)
	
#IO map
def io_map(axis):
	return {
		'11': 4,
		'12': 17,
		'13': 27,
		'14': 22,
		'21': 5,
		'22': 6,
		'23': 13,
		'24': 19,
		'31': 18,
		'32': 23,
		'33': 24,
		'34': 25,
		'41': 12,
		'42': 16,
		'43': 20,
		'44': 21
	}.get(axis, 4)

def io_set(r_c, cs):
	bcm_port = io_map(r_c)
	cs_bool = (cs == '1')
	pi.set_mode(bcm_port, pigpio.OUTPUT)
	pi.write(bcm_port, cs_bool)
	print('set port', bcm_port, cs_bool)

def io_read(r_c):
	bcm_port = io_map(r_c)
	#return bcm_port
	#pi.set_mode(bcm_port, pigpio.OUTPUT)
	#read = GPIO.input(bcm_port)
	pi.set_mode(bcm_port, pigpio.OUTPUT)
	read = pi.read(bcm_port)
	return read
	
if input_len < 3 :
	print('Use more value.')
	sys.exit()
input1 = sys.argv[1]
input2 = sys.argv[2]
row_col_val = input1 + input2

#Check input axis value
check_input(input1, row_count)
check_input(input2, col_count)

if input_len == 3 :
	a = io_read(row_col_val)
	print(a)
	sys.exit()
elif input_len == 4 :
	current_status = sys.argv[3]
	print('set', row_col_val)
	io_set(row_col_val, current_status)
	
else:
	print('IO reset')
	io_rst()
