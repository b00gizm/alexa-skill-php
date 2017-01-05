<?php

namespace Tests;

use Alexa\Alexa;
use Alexa\Card\SimpleCard;
use Alexa\Card\StandardCard;
use Alexa\EventFactory;
use Alexa\EventProcessor;
use Alexa\Handler\LaunchCallbackHandler;
use Alexa\Handler\SessionEndedCallbackHandler;
use Alexa\ImageUrls;
use Alexa\OutputSpeech\PlainTextOutputSpeech;
use Alexa\OutputSpeech\SsmlOutputSpeech;
use Alexa\Reprompt;
use Mockery as m;

class AlexaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var m\MockInterface
     */
    private $factoryMock;

    /**
     * @var m\MockInterface
     */
    private $processorMock;

    /**
     * @var Alexa
     */
    private $alexa;

    public function setUp()
    {
        $this->factoryMock = m::mock(EventFactory::class);
        $this->processorMock = m::mock(EventProcessor::class);

        $this->alexa = new Alexa($this->factoryMock, $this->processorMock);
    }

    public function testOnLaunchRequest()
    {
        $this
            ->processorMock
            ->shouldReceive('setLaunchHandler')
            ->with(LaunchCallbackHandler::class)
        ;

        $this->alexa->onLaunchRequest(function() {});
    }

    public function testOnIntentRequest()
    {
        $this
            ->processorMock
            ->shouldReceive('setIntentHandlers')
            ->with(m::type('array'))
        ;

        $this->alexa->onIntentRequest(function() {});
    }

    public function testOnSessionEndedRequest()
    {
        $this
            ->processorMock
            ->shouldReceive('setSessionEndedHandler')
            ->with(SessionEndedCallbackHandler::class)
        ;

        $this->alexa->onSessionEndedRequest(function() {});
    }

    public function testAddPlainTextOutputSpeech()
    {
        $this->alexa->addPlainTextOutputSpeech("hello world");

        $this->assertInstanceOf(PlainTextOutputSpeech::class, $this->alexa->getResponse()->getOutputSpeech());
        $this->assertEquals("hello world", $this->alexa->getResponse()->getOutputSpeech()->getText());
    }

    public function testSsmlOutputSpeech()
    {
        $this->alexa->addSsmlOutputSpeech("<speak>hello world</speak>");

        $this->assertInstanceOf(SsmlOutputSpeech::class, $this->alexa->getResponse()->getOutputSpeech());
        $this->assertEquals("<speak>hello world</speak>", $this->alexa->getResponse()->getOutputSpeech()->getSsml());
    }

    public function testAddSimpleCard()
    {
        $this->alexa->addSimpleCard("greeting", "hello world");

        $this->assertInstanceOf(SimpleCard::class, $this->alexa->getResponse()->getCard());
        $this->assertEquals("greeting", $this->alexa->getResponse()->getCard()->getTitle());
        $this->assertEquals("hello world", $this->alexa->getResponse()->getCard()->getContent());
    }

    public function testAddStandardCardWithoutImages()
    {
        $this->alexa->addStandardCard("greeting", "hello world");

        $this->assertInstanceOf(StandardCard::class, $this->alexa->getResponse()->getCard());
        $this->assertEquals("greeting", $this->alexa->getResponse()->getCard()->getTitle());
        $this->assertEquals("hello world", $this->alexa->getResponse()->getCard()->getText());
        $this->assertNull($this->alexa->getResponse()->getCard()->getImageUrls());
    }

    public function testAddStandardCardWithImages()
    {
        $this->alexa->addStandardCard(
            "greeting",
            "hello world",
            "http://cdn.example.org/small.jpg",
            "http://cdn.example.org/large.jpg"
        );

        $this->assertInstanceOf(StandardCard::class, $this->alexa->getResponse()->getCard());

        /** @var StandardCard $card */
        $card = $this->alexa->getResponse()->getCard();
        $this->assertEquals("greeting", $card->getTitle());
        $this->assertEquals("hello world", $card->getText());
        $this->assertInstanceOf(ImageUrls::class, $card->getImageUrls());
        $this->assertEquals("http://cdn.example.org/small.jpg", $card->getImageUrls()->getSmallImageUrl());
        $this->assertEquals("http://cdn.example.org/large.jpg", $card->getImageUrls()->getLargeImageUrl());
    }

    public function testAddPlainTextReprompt()
    {
        $this->alexa->addPlainTextReprompt("hello world");

        $this->assertNotNull($this->alexa->getResponse()->getRepromptOutputSpeech());

        /** @var Reprompt $reprompt */
        $repromptOutputSpeech = $this->alexa->getResponse()->getRepromptOutputSpeech();
        $this->assertInstanceOf(PlainTextOutputSpeech::class, $repromptOutputSpeech);
        $this->assertEquals("hello world", $repromptOutputSpeech->getText());
    }

    public function testAddSsmlReprompt()
    {
        $this->alexa->addSsmlReprompt("<speak>hello world</speak>");

        $this->assertNotNull($this->alexa->getResponse()->getRepromptOutputSpeech());

        /** @var Reprompt $reprompt */
        $repromptOutputSpeech = $this->alexa->getResponse()->getRepromptOutputSpeech();
        $this->assertInstanceOf(SsmlOutputSpeech::class, $repromptOutputSpeech);
        $this->assertEquals("<speak>hello world</speak>", $repromptOutputSpeech->getSsml());
    }

    public function testAddSessionAttributes()
    {
        $attributes = ['foo' => 123, 'bar' => ['baz' => 'meh']];

        $this->alexa->addSessionAttributes($attributes);

        $this->assertEquals($attributes, $this->alexa->getResponse()->getSessionAttributes());
    }

    public function testKeepSessionAlive()
    {
        $this->alexa->keepSessionAlive();

        $this->assertFalse($this->alexa->getResponse()->shouldEndSession());
    }
}
