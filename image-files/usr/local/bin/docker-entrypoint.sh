#!/bin/bash

printf "finding key file...\n"
echo $GOOGLE_APPLICATION_CREDENTIALS
gcloud auth activate-service-account --key-file=$GOOGLE_APPLICATION_CREDENTIALS

gcloud config set project $DEVSHELL_PROJECT_ID

tail -f /dev/null