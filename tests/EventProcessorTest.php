<?php

namespace Tests;

use Alexa\Alexa;
use Alexa\Event;
use Alexa\EventProcessor;
use Alexa\Handler\IntentHandlerInterface;
use Alexa\Handler\LaunchHandlerInterface;
use Alexa\Handler\SessionEndedHandlerInterface;
use Alexa\Intent;
use Alexa\Request;
use Alexa\Request\IntentRequest;
use Alexa\Request\LaunchRequest;
use Alexa\Request\SessionEndedRequest;
use Alexa\Response;
use Alexa\Session;
use Mockery as m;

class EventProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var m\MockInterface
     */
    private $alexaMock;

    /**
     * @var m\MockInterface
     */
    private $eventMock;

    public function setUp()
    {
        $this->alexaMock = m::mock(Alexa::class);
        $this->eventMock = m::mock(Event::class);
    }

    public function testProcessWithLaunchRequest()
    {
        $launchHandlerMock = m::mock(LaunchHandlerInterface::class);
        $launchHandlerMock->shouldReceive('handle');

        $processor = new EventProcessor();
        $processor->setLaunchHandler($launchHandlerMock);

        $requestMock = m::mock(LaunchRequest::class);
        $requestMock->shouldReceive('getType')->andReturn(Request::TYPE_LAUNCH);
        $this->eventMock->shouldReceive('getRequest')->andReturn($requestMock);
        $this->eventMock->shouldReceive('getSession')->andReturn(m::mock(Session::class));

        $response = $processor->process($this->alexaMock, $this->eventMock);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testProcessWithIntentRequest()
    {
        $emptyIntentHandlerMock = m::mock(IntentHandlerInterface::class);
        $emptyIntentHandlerMock->shouldReceive('handle')->andReturn(null);

        $intentHandlerMock = m::mock(IntentHandlerInterface::class);
        $intentHandlerMock->shouldReceive('handle')->andReturn(m::mock(Response::class));

        $notToBeCalledIntentHandlerMock = m::mock(IntentHandlerInterface::class);
        $notToBeCalledIntentHandlerMock->shouldNotReceive('handle');

        $handlers = [
            $emptyIntentHandlerMock,
            $intentHandlerMock,
            $notToBeCalledIntentHandlerMock,
        ];

        $requestMock = m::mock(IntentRequest::class);
        $requestMock->shouldReceive('getType')->andReturn(Request::TYPE_INTENT);
        $requestMock->shouldReceive('getIntent')->andReturn(m::mock(Intent::class));

        $this->eventMock->shouldReceive('getRequest')->andReturn($requestMock);
        $this->eventMock->shouldReceive('getSession')->andReturn(m::mock(Session::class));

        $processor = new EventProcessor();
        $processor->setIntentHandlers($handlers);

        $response = $processor->process($this->alexaMock, $this->eventMock);
    }

    public function testProcessWithSessionEndedRequest()
    {
        $sessionEndedHandlerMock = m::mock(SessionEndedHandlerInterface::class);
        $sessionEndedHandlerMock->shouldReceive('handle');

        $processor = new EventProcessor();
        $processor->setSessionEndedHandler($sessionEndedHandlerMock);

        $requestMock = m::mock(SessionEndedRequest::class);
        $requestMock->shouldReceive('getType')->andReturn(Request::TYPE_SESSION_ENDED);
        $this->eventMock->shouldReceive('getRequest')->andReturn($requestMock);
        $this->eventMock->shouldReceive('getSession')->andReturn(m::mock(Session::class));

        $response = $processor->process($this->alexaMock, $this->eventMock);
        $this->assertInstanceOf(Response::class, $response);
    }
}