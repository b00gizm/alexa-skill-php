<?php

namespace Tests\Alexa\Subscriber;

use Alexa\Subscriber\RequestTypeSubscriber;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;

class RequestTypeSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSubscribedEvents()
    {
        $this->assertEquals(
            [
                [
                    'event'  => 'serializer.pre_deserialize',
                    'method' => 'onPreDeserialize',
                ]
            ],
            RequestTypeSubscriber::getSubscribedEvents()
        );
    }

    public function testOnPreDeserializeWithLaunchRequestType()
    {
        $event = new PreDeserializeEvent(
            DeserializationContext::create(),
            ['type' => 'LaunchRequest'],
            ['name' => 'Alexa\Request', 'params' => []]
        );

        $subscriber = new RequestTypeSubscriber();
        $subscriber->onPreDeserialize($event);

        $this->assertEquals(
            'Alexa\Request\LaunchRequest',
            $event->getType()['name']
        );
    }

    public function testOnPreDeserializeWithIntentRequestType()
    {
        $event = new PreDeserializeEvent(
            DeserializationContext::create(),
            ['type' => 'IntentRequest'],
            ['name' => 'Alexa\Request', 'params' => []]
        );

        $subscriber = new RequestTypeSubscriber();
        $subscriber->onPreDeserialize($event);

        $this->assertEquals(
            'Alexa\Request\IntentRequest',
            $event->getType()['name']
        );
    }

    public function testOnPreDeserializeWithSessionEndedRequestType()
    {
        $event = new PreDeserializeEvent(
            DeserializationContext::create(),
            ['type' => 'SessionEndedRequest'],
            ['name' => 'Alexa\Request', 'params' => []]
        );

        $subscriber = new RequestTypeSubscriber();
        $subscriber->onPreDeserialize($event);

        $this->assertEquals(
            'Alexa\Request\SessionEndedRequest',
            $event->getType()['name']
        );
    }

    public function testOnPreDeserializeWithUnknownType()
    {
        $event = new PreDeserializeEvent(
            DeserializationContext::create(),
            ['type' => 'FooRequest'],
            ['name' => 'Alexa\Request', 'params' => []]
        );

        $subscriber = new RequestTypeSubscriber();
        $subscriber->onPreDeserialize($event);

        $this->assertEquals(
            'Alexa\Request',
            $event->getType()['name']
        );
    }
}
