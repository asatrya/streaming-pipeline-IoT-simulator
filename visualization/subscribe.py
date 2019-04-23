from google.cloud import pubsub_v1
from time import sleep
from sys import stdout
import json
import argparse


def callback(message):
    data = json.loads(message.data)
    print(data['speed'])
    stdout.flush()
    message.ack()


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Creates subscription')
    parser.add_argument('--project',
                        help='Example: --project $DEVSHELL_PROJECT_ID',
                        required=True)
    parser.add_argument('--topic',
                        help='topic name',
                        required=True)
    parser.add_argument('--name',
                        help='subscription name',
                        required=True)
    args = parser.parse_args()

    subscriber = pubsub_v1.SubscriberClient()
    topic_path = subscriber.topic_path(args.project, args.topic)
    subscription_path = subscriber.subscription_path(args.project, args.name)

    try:
        subscription = subscriber.create_subscription(subscription_path, topic_path)
    except:
        subscription = subscriber.get_subscription(subscription_path)

    # print('Subscription created: {}'.format(subscription))

    subscriber.subscribe(subscription_path, callback=callback)

    # print('Listening for messages on {}'.format(subscription_path))

    # The subscriber is non-blocking, so we must keep the main thread from
    # exiting to allow it to process messages in the background.
    while True:
        sleep(0.5)