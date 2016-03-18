#reading out batch & sending to site
#works!!

import serial
import urllib2
import urllib

def toSite(url,query_args):
    data = urllib.urlencode(query_args)
    request = urllib2.Request(url,data)
    response = urllib2.urlopen(request).read()
    return response

ser = serial.Serial('/dev/ttyACM1',9600)
serCard = serial.Serial('/dev/ttyACM0',9600)
url = 'http://sjotterkas.pi/game/create'
url2 = 'http://sjotterkas.pi/game/update'
url3 = 'http://sjotterkas.pi/game/score'

counter = 0
newgame = 0
check = 1
play = 0

while check:

        if newgame == 0:
            new = ser.readline() #readout buttons
            new = new.split('\r') #plaats een spatie + enter erachter
            new = new[0]
            print new
            if new == 'new':
                    print "nieuw maken"
                    newgame = newgame + 1
                    query_args = { 'new':'new'}
                    response = toSite(url,query_args)
        print newgame

        if newgame == 1:
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
                if response == "play":
                    play = 1
                    newgame = 2

        if play == 1:
            print "binnen play"
            action = ser.readline() #readout buttons
            action = action.split('\r') #plaats een spatie + enter erachter
            action = action[0]
            print action
            if action == "goal black":
                query_args = { 'team':'black','action':'goal'}
                response = toSite(url3,query_args)
            elif action == "goal green":
                query_args = { 'team':'green','action':'goal'}
                response = toSite(url3,query_args)
            elif action == "cancel green":
                query_args = { 'team':'green','action':'cancel'}
                response = toSite(url3,query_args)
            elif action == "cancel black":
                query_args = { 'team':'black','action':'cancel'}
                response = toSite(url3,query_args)
            elif action == new:
                newgame = 1
                play = 0
                query_args = { 'new':'new'}
                response = toSite(url,query_args)
            print response
