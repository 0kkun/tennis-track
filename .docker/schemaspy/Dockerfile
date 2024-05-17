FROM schemaspy/schemaspy:6.2.4

USER root

RUN apk --update --no-cache add \
    python3 \
    curl

RUN curl https://bootstrap.pypa.io/get-pip.py |python3
RUN pip install awscli

COPY ./entrypoint.sh /

ENTRYPOINT ["/entrypoint.sh"]