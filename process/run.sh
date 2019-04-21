#!/bin/bash

echo 'launching streaming pipeline'
echo 'usage: ./run.sh Project BigQueryDataset.Table PubSubTopic Bucket-ID Bucket-Folder'

if [[ "$#" -ne 5 ]]; then
  echo 'wrong usage'
  exit
fi

python pipeline.py --project=$1 --bq=$2 --pubsub=$3 --bucketid=$4 --bucketfolder=$5