FROM python:3
ADD start_sink.py /
ADD auth.py /
ADD schema.py /
RUN pip install pulsar
CMD [ "python", "./start_sink.py" ]