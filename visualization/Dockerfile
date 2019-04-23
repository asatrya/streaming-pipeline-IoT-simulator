FROM python:3.6

RUN apt-get update
RUN apt-get install -y nano
RUN apt-get install -y curl
RUN apt-get install -y lsb-release

# Create environment variable for correct distribution
ENV CLOUD_SDK_REPO cloud-sdk-$(lsb_release -c -s)

RUN export CLOUD_SDK_REPO="cloud-sdk-$(lsb_release -c -s)" && \
    echo "deb http://packages.cloud.google.com/apt $CLOUD_SDK_REPO main" | tee -a /etc/apt/sources.list.d/google-cloud-sdk.list && \
    curl https://packages.cloud.google.com/apt/doc/apt-key.gpg | apt-key add - && \
    apt-get update -y && apt-get install google-cloud-sdk -y

ENV GOOGLE_APPLICATION_CREDENTIALS /usr/local/etc/key.json
COPY image-files/ /
RUN chmod 777 /usr/local/bin/websocketd

RUN mkdir /app
WORKDIR /app
COPY . .
RUN chmod -R 777 .

RUN pip install -r requirements.txt

#CMD ["docker-entrypoint.sh"]
CMD ["tail", "-f", "/dev/null"]