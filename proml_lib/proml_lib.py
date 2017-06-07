import math
import urllib as ul
import urllib2 as ul2
import time


def sendMessage(JOB_NUMBER,STATUS):
	endpoint = 'http://proml.marchese.me/api/sendmail.php'
	final_endpoint = endpoint + '?ID=' + JOB_NUMBER + '&STATUS='+STATUS 
	results = getURL(final_endpoint)
	if results == 'sent':
		return True
	else:
		return False

def getURL(URL):
    have_results = False
    request = None
    while (not have_results):
        try:
            temp = ul2.urlopen(URL).read()
        except urllib2.HTTPError as e:
            return e
        if len(temp) > 0:
            request = temp
            have_results = True
            break
        time.sleep(10)
    return request

