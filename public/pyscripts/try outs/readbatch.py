import serial
ser = serial.Serial('/dev/ttyACM0',9600)
while 1:
	text = ser.readline()
	print text
	print text.split('/')
