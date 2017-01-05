<?php

namespace Alexa;

use Alexa\Card\LinkAccountCard;
use Alexa\Card\SimpleCard;
use Alexa\Card\StandardCard;
use Alexa\Handler\IntentCallbackHandler;
use Alexa\Handler\LaunchCallbackHandler;
use Alexa\Handler\SessionEndedCallbackHandler;
use Alexa\OutputSpeech\PlainTextOutputSpeech;
use Alexa\OutputSpeech\SsmlOutputSpeech;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class Alexa
{
    /**
     * @var EventFactory
     */
    private $factory;

    /**
     * @var EventProcessor
     */
    private $processor;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var Response
     */
    private $response;

    public function __construct(
        EventFactory $factory,
        EventProcessorInterface $processor = null,
        Serializer $serializer = null)
    {
        if (!$serializer) {
            $serializer = $this->createDefaultSerializer();
        }

        if (!$processor) {
            $processor = $this->createDefaultEventProcessor();
        }

        $this->factory    = $factory;
        $this->processor  = $processor;
        $this->serializer = $serializer;
        $this->response   = null;
    }

    /**
     * Convenience method for providing a launch request handler as closure
     *
     * @param \Closure $callback
     */
    public function onLaunchRequest(\Closure $callback)
    {
        $this->processor->setLaunchHandler(new LaunchCallbackHandler($callback));
    }

    /**
     * Convenience method for providing an intent request handler as closure
     *
     * @param \Closure $callback
     */
    public function onIntentRequest(\Closure $callback)
    {
        $this->processor->setIntentHandlers([new IntentCallbackHandler($callback)]);
    }

    /**
     * Convenience method for providing a session ended request handler as closure
     *
     * @param \Closure $callback
     */
    public function onSessionEndedRequest(\Closure $callback)
    {
        $this->processor->setSessionEndedHandler(new SessionEndedCallbackHandler($callback));
    }

    /**
     * Processes a Alexa JSON request payload and return a correct JSON response
     *
     * @param string $json
     * @return string
     */
    public function process($json)
    {
        $event = $this->factory->createFromJson($json);
        $response = $this->processor->process($this, $event);

        return $this->serializer->serialize($response, 'json');
    }

    /**
     * Convenience factory method for creating a (minimal) valid response object
     *
     * @return $this
     */
    public function defaultReponse()
    {
        $this->response = new Response();

        return $this;
    }

    /**
     * Convenience method for adding a plain text output speech to a response
     *
     * @param $text
     *
     * @return $this
     */
    public function addPlainTextOutputSpeech($text)
    {
        $this
            ->getResponse()
            ->getResponseContent()
            ->setOutputSpeech(new PlainTextOutputSpeech($text))
        ;

        return $this;
    }

    /**
     * Convenience method for adding a SSML output speech to a response
     *
     * @param $ssml
     *
     * @return $this
     */
    public function addSsmlOutputSpeech($ssml)
    {
        $this
            ->getResponse()
            ->getResponseContent()
            ->setOutputSpeech(new SsmlOutputSpeech($ssml))
        ;

        return $this;
    }

    /**
     * Convenience method for adding a simple card to a response
     *
     * @param $title
     * @param $content
     *
     * @return $this
     */
    public function addSimpleCard($title, $content)
    {
        $simpleCard = new SimpleCard();
        $simpleCard->setTitle($title);
        $simpleCard->setContent($content);

        $this
            ->getResponse()
            ->getResponseContent()
            ->setCard($simpleCard)
        ;

        return $this;
    }

    /**
     * Convenience method for adding a standard card to a response
     *
     * @param $title
     * @param $text
     * @param null $smallImageUrl
     * @param null $largeImageUrl
     *
     * @return $this
     */
    public function addStandardCard($title, $text, $smallImageUrl = null, $largeImageUrl = null)
    {
        $standardCard = new StandardCard();
        $standardCard->setTitle($title);
        $standardCard->setText($text);

        if ($smallImageUrl || $largeImageUrl) {
            $imageUrls = new ImageUrls();
            $imageUrls->setLargeImageUrl($largeImageUrl);
            $imageUrls->setSmallImageUrl($smallImageUrl);

            $standardCard->setImageUrls($imageUrls);
        }

        $this
            ->getResponse()
            ->getResponseContent()
            ->setCard($standardCard)
        ;

        return $this;
    }

    /**
     * Convenience method for adding a "link account" card to a response
     *
     * @return $this
     */
    public function addLinkAccountCard()
    {
        $this
            ->getResponse()
            ->getResponseContent()
            ->setCard(new LinkAccountCard())
        ;

        return $this;
    }

    /**
     * Convenience method for adding a plain text reprompt to a response
     *
     * @param $text
     *
     * @return $this
     */
    public function addPlainTextReprompt($text)
    {
        $this
            ->getResponse()
            ->getResponseContent()
            ->setReprompt(new Reprompt(new PlainTextOutputSpeech($text)))
        ;

        return $this;
    }

    /**
     * Convenience method for adding a SSML reprompt to a response
     *
     * @param $ssml
     *
     * @return $this
     */
    public function addSsmlReprompt($ssml)
    {
        $this
            ->getResponse()
            ->getResponseContent()
            ->setReprompt(new Reprompt(new SsmlOutputSpeech($ssml)))
        ;

        return $this;
    }

    /**
     * Convenience method for adding session attributes to a response
     *
     * @param array $sessionAttributes
     *
     * @return $this
     */
    public function addSessionAttributes(array $sessionAttributes)
    {
        $this->getResponse()->setSessionAttributes($sessionAttributes);

        return $this;
    }

    /**
     * Convenience method for keeping an Alexa session alive
     *
     * @return $this
     */
    public function keepSessionAlive()
    {
        $this->getResponse()->setShouldEndSession(false);

        return $this;
    }

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @return EventFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return EventProcessor
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * creates a default serializer object
     *
     * @return Serializer
     */
    private function createDefaultSerializer()
    {
        return SerializerBuilder::create()->build();
    }

    private function createDefaultEventProcessor()
    {
        return new EventProcessor();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        if (!$this->response) {
            $this->response = new Response();
        }

        return $this->response;
    }
}
