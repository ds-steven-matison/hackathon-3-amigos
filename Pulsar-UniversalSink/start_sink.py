import pulsar, time
from pulsar.schema import *
import json
import requests
from schema import TableSchema
import auth

#DSE Auth
r = requests.post(auth.auth_url, data=auth.body, headers=auth.auth_header)
response_dict = json.loads(r.text)
dse_token = response_dict.get("authToken")

#DSE insert
insert_headers = {'X-Cassandra-Token': dse_token,'Content-type': 'application/json'}

msjdata = String()

#Create Pulsar client
client = pulsar.Client(auth.service_url,
                        authentication=pulsar.AuthenticationToken(auth.pulsar_token),
                        tls_trust_certs_file_path=auth.trust_certs)
#Create subscriber
consumer = client.subscribe('[topic goes here]', '[subscription name here]',  schema=AvroSchema(TableSchema))

#Check for new messages and wait.
waitingForMsg = True
while waitingForMsg:
    try:
        msg = consumer.receive(2000)
        msjdata = str(msg.value()).replace("'", '"')
        print(msjdata)
        consumer.acknowledge(msg)

        #Post to DSE
        r = requests.post(auth.insert_row_url, data=msjdata, headers=insert_headers)
        print(str(r))
    except:
        print("Still waiting for a message...");

    time.sleep(1)

client.close()