#reading out batch & sending to site

import serial
import urllib2
import urllib

ser = serial.Serial('/dev/ttyACM0',9600)
url = 'http://localhost/score'
counter = 0
while 1:
	text = ser.readline()
	print text
	if counter < 2:
            counter = counter + 1
        else:
            team = text.split('/')
            print team
            print len(team)
            if len(team) > 1:
                query_args = { 'team':team[1]}
                data = urllib.urlencode(query_args)
                request = urllib2.Request(url,data)
                response = urllib2.urlopen(request).read()
                print response
