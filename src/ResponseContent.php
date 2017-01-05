<?php

namespace Alexa;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class ResponseContent
{
    /**
     * @SerializedName("shouldEndSession")
     * @Accessor(getter="shouldEndSession",setter="setShouldEndSession")
     * @Type("boolean")
     * @var bool
     */
    private $shouldEndSession;

    /**
     * @SerializedName("outputSpeech")
     * @Type("Alexa\OutputSpeech")
     * @var OutputSpeech
     */
    private $outputSpeech;

    /**
     * @Type("Alexa\Card")
     * @var Card
     */
    private $card;

    /**
     * @Type("Alexa\Reprompt")
     * @var Reprompt
     */
    private $reprompt;

    public function __construct()
    {
        $this->shouldEndSession = true;
    }

    /**
     * @return boolean
     */
    public function shouldEndSession()
    {
        return $this->shouldEndSession;
    }

    /**
     * @param boolean $shouldEndSession
     */
    public function setShouldEndSession($shouldEndSession)
    {
        $this->shouldEndSession = $shouldEndSession;
    }

    /**
     * @return OutputSpeech
     */
    public function getOutputSpeech()
    {
        return $this->outputSpeech;
    }

    /**
     * @param OutputSpeech $outputSpeech
     */
    public function setOutputSpeech(OutputSpeech $outputSpeech)
    {
        $this->outputSpeech = $outputSpeech;
    }

    /**
     * @return Card
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param Card $card
     */
    public function setCard(Card $card)
    {
        $this->card = $card;
    }

    /**
     * @return Reprompt
     */
    public function getReprompt()
    {
        return $this->reprompt;
    }

    /**
     * @param Reprompt $reprompt
     */
    public function setReprompt(Reprompt $reprompt)
    {
        $this->reprompt = $reprompt;
    }
}
