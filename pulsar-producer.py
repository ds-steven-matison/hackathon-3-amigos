import pulsar
import argparse
import sys,os
from pulsar.schema import *
import json
# parse incoming STDIN to data variable
parser = argparse.ArgumentParser()
parser.add_argument('infile',
                    default=sys.stdin,
                    type=argparse.FileType('r'),
                    nargs='?')
args = parser.parse_args()
data = args.infile.read()
print(data)
y = json.loads(data);
service_url = ''
# Use default CA certs for your environment
# RHEL/CentOS:
trust_certs='/etc/ssl/certs/ca-bundle.crt'
# Debian/Ubuntu:
# trust_certs='/etc/ssl/certs/ca-certificates.crt'
token=''
client = pulsar.Client(service_url,
                        authentication=pulsar.AuthenticationToken(token),
                        tls_trust_certs_file_path=trust_certs)
class Example(Record):
    voter_uuid = String() 
    face_photo_1 = String()
    face_photo_2 = String()
    face_photo_3 = String()
    fingerprint_left_pinky = String()
    fingerprint_left_ring = String()
    fingerprint_left_middle = String()
    fingerprint_left_index = String()
    fingerprint_left_thumb = String()
    fingerprint_right_thumb = String()
    fingerprint_right_index = String()
    fingerprint_right_middle = String()
    fingerprint_right_ring = String()
    fingerprint_right_pinky = String()
    signature = String()
    updated_ts = String()
producer = client.create_producer(topic='', schema=AvroSchema(Example))
producer.send(Example(voter_uuid=y["voter_uuid"],
face_photo_1=y["face_photo_1"],
face_photo_2=y["face_photo_2"],
face_photo_3=y["face_photo_3"],
fingerprint_left_pinky=y["fingerprint_left_pinky"],
fingerprint_left_ring=y["fingerprint_left_ring"],
fingerprint_left_index=y["fingerprint_left_index"],
fingerprint_left_thumb=y["fingerprint_left_thumb"],
fingerprint_right_thumb=y["fingerprint_right_thumb"],
fingerprint_right_index=y["fingerprint_right_index"],
fingerprint_right_middle=y["fingerprint_right_middle"],
fingerprint_right_ring=y["fingerprint_right_ring"],
fingerprint_right_pinky=y["fingerprint_right_pinky"],
signature=y["signature"],
updated_ts=y["updated_ts"]))
client.close()