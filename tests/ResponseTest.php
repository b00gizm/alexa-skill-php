<?php

namespace Tests;

use Alexa\Card\SimpleCard;
use Alexa\OutputSpeech\PlainTextOutputSpeech;
use Alexa\Reprompt;
use Alexa\Response;
use JMS\Serializer\SerializerBuilder;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testSerializeToJson()
    {
        $response = new Response();
        $response->setSessionAttributes([
            'supportedHoriscopePeriods' => [
                'daily'   => true,
                'weekly'  => false,
                'monthly' => false,
            ]
        ]);

        $response->getResponseContent()->setShouldEndSession(false);

        $outputSpeech = new PlainTextOutputSpeech(
            'Today will provide you a new learning opportunity.'
        );
        $response->setOutputSpeech($outputSpeech);

        $card = new SimpleCard();
        $card->setTitle('Horoscope');
        $card->setContent('Today will provide you a new learning opportunity.');
        $response->setCard($card);

        $repromptOutput = new PlainTextOutputSpeech(
            'Can I help you with anything else?'
        );
        $response
            ->getResponseContent()
            ->setReprompt(new Reprompt($repromptOutput))
        ;

        $expectedJsonArray = json_decode(
            $this->getFixtureContents('04_response'),
            true
        );

        $serializer = SerializerBuilder::create()->build();
        $actualJsonArray = json_decode(
            $serializer->serialize($response, 'json'),
            true
        );

        $this->assertEquals($expectedJsonArray, $actualJsonArray);
    }

    protected function getFixtureContents($name)
    {
        return file_get_contents(__DIR__.'/fixtures/'.$name.'.json');
    }
}