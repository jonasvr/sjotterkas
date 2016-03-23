import urllib2
import urllib

query_args = { 'team':'active'}

url = 'http://localhost/score'

data = urllib.urlencode(query_args)

request = urllib2.Request(url,data)

response = urllib2.urlopen(request).read()

print response