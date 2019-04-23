#!/bin/bash

echo 'launching streaming pipeline'
echo 'usage: ./run.sh Project BigQueryDataset.Table PubSubTopic-read Bucket-ID Bucket-Folder PubSubTopic-write'

if [[ "$#" -ne 6 ]]; then
  echo 'wrong usage'
  exit
fi

python pipeline.py --project=$1 --bq=$2 --pubsubread=$3 --bucketid=$4 --bucketfolder=$5 --pubsubwrite=$6