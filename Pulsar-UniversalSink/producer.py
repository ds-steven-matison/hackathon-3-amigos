import pulsar, time
from pulsar.schema import *
import argparse
import sys,os
import json
import requests

service_url = '[service url goes here]'
print("parse created")

# Debian/Ubuntu:
trust_certs = '/etc/ssl/certs/ca-certificates.crt'
token = '[token goes here]'
client = pulsar.Client(service_url, authentication=pulsar.AuthenticationToken(token), tls_trust_certs_file_path=trust_certs)
print("client created")

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

producer = client.create_producer(topic='[topic goes here]', schema=AvroSchema(Example))
print("producer created")

producer.send(Example(voter_uuid="voter_uuid9",
face_photo_1="face_photo_1",
face_photo_2="face_photo_2",
face_photo_3="face_photo_3",
fingerprint_left_pinky="fingerprint_left_pinky",
fingerprint_left_ring="fingerprint_left_ring",
fingerprint_left_index="fingerprint_left_index",
fingerprint_left_thumb="fingerprint_left_thumb",
fingerprint_right_thumb="fingerprint_right_thumb",
fingerprint_right_index="fingerprint_right_index",
fingerprint_right_middle="fingerprint_right_middle",
fingerprint_right_ring="fingerprint_right_ring",
fingerprint_right_pinky="fingerprint_right_pinky",
signature="signature",
updated_ts="2021-04-01T00:00:00Z"))
client.close()
print("message sent")