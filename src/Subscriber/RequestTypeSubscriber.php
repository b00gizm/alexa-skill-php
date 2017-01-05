<?php

namespace Alexa\Subscriber;

use Alexa\Request;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;

class RequestTypeSubscriber implements EventSubscriberInterface
{
    /**
     * Returns the events to which this class has subscribed.
     *
     * Return format:
     *     array(
     *         array('event' => 'the-event-name', 'method' => 'onEventName', 'class' => 'some-class', 'format' => 'json'),
     *         array(...),
     *     )
     *
     * The class may be omitted if the class wants to subscribe to events of all classes.
     * Same goes for the format key.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event'  => 'serializer.pre_deserialize',
                'method' => 'onPreDeserialize',
            ],
        ];
    }

    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        $type = $event->getType();
        if ('Alexa\Request' === $type['name']) {
            $data = $event->getData();
            switch ($data['type']) {
                case Request::TYPE_LAUNCH:
                    $type['name'] = 'Alexa\Request\LaunchRequest';
                    break;
                case Request::TYPE_INTENT:
                    $type['name'] = 'Alexa\Request\IntentRequest';
                    break;
                case Request::TYPE_SESSION_ENDED:
                    $type['name'] = 'Alexa\Request\SessionEndedRequest';
                    break;
                default:
                    break;
            }

            $event->setType($type['name'], $type['params']);
        }
    }
}
