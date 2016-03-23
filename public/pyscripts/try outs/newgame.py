#reading out batch & sending to site

import serial
import urllib2
import urllib

ser = serial.Serial('/dev/ttyACM1',9600)
serCard = serial.Serial('/dev/ttyACM2',9600)
url = 'http://localhost/game/create'
url2 = 'http://localhost/game/update'

counter = 0
newgame = 0
check = 1
counter = 0

while check:

        print "counter"
        print counter
        counter = counter + 1
        if newgame == 0:
            new = ser.readline() #readout buttons
            new = new.split('\r') #plaats een spatie + enter erachter
            new = new[0]
            print new
            if new == 'new':
                    print "nieuw maken"
                    newgame = newgame + 1
                    query_args = { 'new':'new'}
                    data = urllib.urlencode(query_args)
                    request = urllib2.Request(url,data)
                    response = urllib2.urlopen(request).read()
                    print response
        print newgame

        if newgame:
                print "binnen kaartlezen"
                text = serCard.readline()
                team = text.split('/')
                print team
                #print len(team)
                if len(team) > 1:
                    query_args = { 'player':team[1]}
                    data = urllib.urlencode(query_args)
                    request = urllib2.Request(url2,data)
                    response = urllib2.urlopen(request).read()
                    print response
                #print newgame
