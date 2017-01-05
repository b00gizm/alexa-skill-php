<?php

namespace Tests\Alexa;

use Alexa\EventFactory;
use Alexa\Exception\LogicException;
use Alexa\Request;
use Alexa\Request\IntentRequest;
use Alexa\Request\SessionEndedRequest;
use Alexa\Slot;
use JMS\Serializer\SerializerBuilder;
use Mockery as m;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromJsonForLaunchRequest()
    {
        $launchJson = $this->getFixtureContents('01_launch_request');

        $factory = new EventFactory();
        $event = $factory->createFromJson($launchJson);

        $this->assertInstanceOf('Alexa\\Event', $event);
        $this->assertEquals('1.0', $event->getVersion());

        $request = $event->getRequest();
        $this->assertInstanceOf('Alexa\Request\LaunchRequest', $request);
        $this->assertEquals(
            'amzn1.echo-api.request.0000000-0000-0000-0000-00000000000',
            $request->getId()
        );
        $this->assertEquals(Request::TYPE_LAUNCH, $request->getType());
        $this->assertEquals(1431520496, $request->getTimestamp()->getTimestamp());
        $this->assertEquals('Z', $request->getTimestamp()->getTimezone()->getName());
        $this->assertEquals(0, $request->getTimestamp()->getOffset());

        $session = $event->getSession();
        $this->assertInstanceOf('Alexa\\Session', $session);
        $this->assertEquals(
            'amzn1.echo-api.session.0000000-0000-0000-0000-00000000000',
            $session->getId()
        );
        $this->assertTrue($session->isNew());
        $this->assertEquals([
            'applicationId' => 'amzn1.echo-sdk-ams.app.000000-d0ed-0000-ad00-000000d00ebe',
        ], $session->getApplication());
        $this->assertEquals([
            'userId' => 'amzn1.account.AM3B00000000000000000000000',
        ], $session->getUser());
        $this->assertEquals([], $session->getAttributes());
    }

    public function testCreateFromJsonForIntentRequest()
    {
        $intentJson = $this->getFixtureContents('02_intent_request');

        $factory = new EventFactory();
        $event = $factory->createFromJson($intentJson);

        $this->assertInstanceOf('Alexa\\Event', $event);
        $this->assertEquals('1.0', $event->getVersion());

        /** @var IntentRequest $request */
        $request = $event->getRequest();
        $this->assertInstanceOf('Alexa\Request\IntentRequest', $request);
        $this->assertEquals(
            'amzn1.echo-api.request.0000000-0000-0000-0000-00000000000',
            $request->getId()
        );
        $this->assertEquals(Request::TYPE_INTENT, $request->getType());
        $this->assertEquals(1431520496, $request->getTimestamp()->getTimestamp());
        $this->assertEquals('Z', $request->getTimestamp()->getTimezone()->getName());
        $this->assertEquals(0, $request->getTimestamp()->getOffset());

        $intent = $request->getIntent();
        $this->assertEquals('GetZodiacHoroscopeIntent', $intent->getName());

        $slots = $intent->getSlots();
        $this->assertEquals(1, sizeof($slots));

        $keys = array_keys($slots);
        $this->assertEquals('ZodiacSign', $keys[0]);

        /** @var Slot $firstSlot */
        $firstSlot = $slots[$keys[0]];
        $this->assertEquals('ZodiacSign', $firstSlot->getName());
        $this->assertEquals('virgo', $firstSlot->getValue());

        $session = $event->getSession();
        $this->assertInstanceOf('Alexa\\Session', $session);
        $this->assertEquals(
            'amzn1.echo-api.session.0000000-0000-0000-0000-00000000000',
            $session->getId()
        );
        $this->assertFalse($session->isNew());
        $this->assertEquals([
            'applicationId' => 'amzn1.echo-sdk-ams.app.000000-d0ed-0000-ad00-000000d00ebe',
        ], $session->getApplication());
        $this->assertEquals([
            'userId' => 'amzn1.account.AM3B00000000000000000000000',
        ], $session->getUser());
        $this->assertEquals([
            'supportedHoroscopePeriods' => [
                'daily'   => true,
                'weekly'  => false,
                'monthly' => false,
            ],
        ], $session->getAttributes());
    }

    public function testCreateFromJsonForSessionEndedRequest()
    {
        $sessionEndedJson = $this->getFixtureContents('03_session_ended_request');

        $factory = new EventFactory();
        $event = $factory->createFromJson($sessionEndedJson);

        $this->assertInstanceOf('Alexa\\Event', $event);
        $this->assertEquals('1.0', $event->getVersion());

        /** @var SessionEndedRequest $request */
        $request = $event->getRequest();
        $this->assertInstanceOf('Alexa\Request\SessionEndedRequest', $request);
        $this->assertEquals(
            'amzn1.echo-api.request.0000000-0000-0000-0000-00000000000',
            $request->getId()
        );
        $this->assertEquals(
            SessionEndedRequest::REASON_USER_INITIATED,
            $request->getReason()
        );
        $this->assertEquals(Request::TYPE_SESSION_ENDED, $request->getType());
        $this->assertEquals(1431520496, $request->getTimestamp()->getTimestamp());
        $this->assertEquals('Z', $request->getTimestamp()->getTimezone()->getName());
        $this->assertEquals(0, $request->getTimestamp()->getOffset());

        $session = $event->getSession();
        $this->assertInstanceOf('Alexa\\Session', $session);
        $this->assertEquals(
            'amzn1.echo-api.session.0000000-0000-0000-0000-00000000000',
            $session->getId()
        );
        $this->assertFalse($session->isNew());
        $this->assertEquals([
            'applicationId' => 'amzn1.echo-sdk-ams.app.000000-d0ed-0000-ad00-000000d00ebe',
        ], $session->getApplication());
        $this->assertEquals([
            'userId' => 'amzn1.account.AM3B00000000000000000000000',
        ], $session->getUser());
        $this->assertEquals([
            'supportedHoroscopePeriods' => [
                'daily'   => true,
                'weekly'  => false,
                'monthly' => false,
            ],
        ], $session->getAttributes());
    }

    public function testAddSubscriberWithAlreadyExistingSerializer()
    {
        $serializer = SerializerBuilder::create()->build();
        $factory = new EventFactory($serializer);

        $subscriberMock = m::mock(
            'JMS\\Serializer\\EventDispatcher\\EventSubscriberInterface'
        );

        $this->expectException(LogicException::class);

        $factory->addSubscriber($subscriberMock);
    }

    protected function getFixtureContents($name)
    {
        return file_get_contents(__DIR__.'/fixtures/'.$name.'.json');
    }
}
