# Pulsar-UniversalSink
Consumes from a Pulsar Topic and inserts into a destination C* table using Startgate REST API.

# Settings
The Auth.py file should be modified to include endpoints information.
The Schema.py file should be modified to specify the structure of the table.
The producer.py and start_sink.py should be modified with token,topic,subscription,etc.

# Run it with Docker
1. Go to files directory: 
`cd <directory>`

2. Build the docker image
docker build -t universalsink .

2. Run Your Image
docker run universalsink

# Run without docker
Clone this repo, install Python 3.7+ and install run the following commands
`pip install pulsar`
