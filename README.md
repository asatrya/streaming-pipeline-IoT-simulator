ETL Pipeline on GCP. PubSub publisher which simulates IoT sensors streaming data. PubSub subscriber as an ingress. DataFlow as data transform. BigQuery as a sink.

## publish

Command:

```bash
./run.sh
```

Data is from sensors along San Diego highway. Sensors publish speeds of cars in a particular lane.

`speedFactor` 60 sends roughly 477 events every 5 seconds

sensors' data format:
```
TIMESTAMP,LATITUDE,LONGITUDE,FREEWAY_ID,FREEWAY_DIR,LANE,SPEED \
2008-11-01 00:00:00,32.749679,-117.155519,163,S,1,71.2
```

## process

Consumes PubSub topic stream in DataFlow, calculates average speed on each highway, 
and then sinks to BigQuery.

creates BigQuery dataset and table:

```bash
./init.sh iot.sensors
```

runs Apache Beam pipeline on Cloud DataFlow backend:

```bash
./run.sh $DEVSHELL_PROJECT_ID iot.sensors sensors bia-stream iot-stream sensorout
```

## visualization

Run websocket:

```bash
websocketd --port=9000 --passenv=GOOGLE_APPLICATION_CREDENTIALS python subscribe.py --project=$DEVSHELL_PROJECT_ID --topic=sensorout --name=sensoroutSub
```