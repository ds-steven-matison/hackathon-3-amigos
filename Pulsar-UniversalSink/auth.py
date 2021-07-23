from pulsar.schema import *

#Pulsar Auth Debian/Ubuntu:
service_url = 'pulsar+ssl://.....:6651'
trust_certs = '/etc/ssl/certs/ca-certificates.crt'
pulsar_token = ''

#DSE Auth
auth_url = "http://[IP Address]:8081/v1/auth"
auth_header = {'Content-type': 'application/json'}
body = '{"username": "cassandra","password": "cassandra"}'
insert_row_url = "http://[IP Address]:8082/v2/keyspaces/biometrics/biometrics_by_voter"