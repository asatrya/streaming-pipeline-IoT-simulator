#!/bin/bash

echo 'creating BigQuery dataset'
echo 'usage: ./init.sh BigQueryDataset.Table'

if [ "$#" -ne 1 ]; then
  echo 'wrong usage'
  exit
fi

bq mk iot
bq mk -t $1 freeway:STRING,speed:FLOAT,window_start:TIMESTAMP,window_end:TIMESTAMP

echo '+'
