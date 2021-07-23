from pulsar.schema import *

#Pulsar Auth Debian/Ubuntu:
service_url = 'pulsar+ssl://pulsar-gcp-useast4.streaming.datastax.com:6651'
trust_certs = '/etc/ssl/certs/ca-certificates.crt'
pulsar_token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJjbGllbnQ7MzJhMDkyZWEtMjBiMS00NzQ1LWIzYWQtOTFkNGFiNDU2YWJkO2RISmxjeTFoYldsbmIzTXRhR0ZqYXkxblkzQT0ifQ.YEJTwuUr0ywu-cwK3Cf1o2iUOSCn6b2899E0bxnQltM-4yiT161oWcudhXjR-TXYpoAJ-sGl0TJ0117WBMRHw4-8zbZ3EM8u7VBGKS5xJfiK0wiMzz0v00W-PauL-gwQ_CAaUGaulBkLz13IVUfN6XPpdfdOUJ4ESllJ19lKrxFnjJ4TfdkBtqwbnCg4uOf-8RmfSX_C27jc6UxaLk8cEaSnMTn0skXTDvZhEs43t41e7iiyO1N47t_bAzl5uwCiVY4xOLfCZko9p6Kf8Sb68BCxxDy1jcrJjNaSD3RlY0MetiDrjNqP0gBHepqLVBqdiM2ptyeSlIyIEwq_mtHtcg'

#DSE Auth
auth_url = "http://13.92.103.252:8081/v1/auth"
auth_header = {'Content-type': 'application/json'}
body = '{"username": "cassandra","password": "cassandra"}'
insert_row_url = "http://13.92.103.252:8082/v2/keyspaces/biometrics/biometrics_by_voter"