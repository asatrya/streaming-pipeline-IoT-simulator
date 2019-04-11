#!/bin/bash

gsutil cp gs://cloud-training-demos/sandiego/sensor_obs2008.csv.gz .

pip install --upgrade google-cloud-pubsub
