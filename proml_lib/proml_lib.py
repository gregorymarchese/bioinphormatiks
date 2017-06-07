import math
import urllib as ul
import urllib2 as ul2
import time
import json
import pprint
import datetime

def updateJobConfig(JOB_NUMBER, NEW_STATUS):
	local_dir = 'job_config/'
	filename = local_dir+'job_'+str(JOB_NUMBER)+'.json'
	config = None
	with open(filename) as file:
		config = json.load(file)
	config['status'] = NEW_STATUS
	if NEW_STATUS == 'completed':
		now = datetime.datetime.now()
		config['run_end'] = now.strftime('%Y-%m-%d %H:%M:%S')
	with open(filename, 'w') as file:
  		json.dump(config, file, ensure_ascii=False)

def sendMessage(JOB_NUMBER,STATUS):
	return bool(getURL('http://proml.marchese.me/send_job_status.php?ID=' + str(JOB_NUMBER) + '&STATUS='+STATUS))

def getURL(URL):
    have_results = False
    request = None
    while (not have_results):
        try:
            temp = ul2.urlopen(URL).read()
        except ul2.HTTPError as e:
            return e
        if len(temp) > 0:
            request = temp
            have_results = True
            break
        time.sleep(10)
    return request

updateJobConfig(18,'completed')