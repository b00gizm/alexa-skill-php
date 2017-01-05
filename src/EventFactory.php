<?php

namespace Alexa;

use Alexa\Exception\LogicException;
use Alexa\Subscriber\RequestTypeSubscriber;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class EventFactory
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var array
     */
    private $subscribers;

    public function __construct(Serializer $serializer = null)
    {
        $this->serializer  = $serializer;
        $this->subscribers = $this->getDefaultSubscribers();
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        if ($this->serializer) {
            throw new LogicException(
                'Cannot add subscribers for already existing serializer'
            );
        }

        $this->subscribers[] = $subscriber;
    }

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        if (!$this->serializer) {
            $this->serializer = $this->createDefaultSerializer();
        }

        return $this->serializer;
    }

    /**
     * Creates an Alexa request from JSON payload
     *
     * @param $json
     *
     * @return null|Event
     */
    public function createFromJson($json)
    {
        return $this->getSerializer()->deserialize($json, 'Alexa\\Event', 'json');
    }

    /**
     * creates a default serializer object
     *
     * @return Serializer
     */
    private function createDefaultSerializer()
    {
        $builder = SerializerBuilder::create();
        if (!empty($this->subscribers)) {
            $self = $this;
            $builder->configureListeners(function(EventDispatcher $dispatcher) use ($self) {
                foreach ($self->subscribers as $subscriber) {
                    $dispatcher->addSubscriber($subscriber);
                }
            });
        }

        return $builder->build();
    }

    protected function getDefaultSubscribers()
    {
        return [
            new RequestTypeSubscriber(),
        ];
    }
}
