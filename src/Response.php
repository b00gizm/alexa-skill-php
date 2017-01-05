<?php

namespace Alexa;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class Response
{
    /**
     * @Type("string")
     * @var string
     */
    private $version;

    /**
     * @SerializedName("sessionAttributes")
     * @Type("array<string,array>")
     * @var array
     */
    private $sessionAttributes;

    /**
     * @SerializedName("response")
     * @Type("Alexa\ResponseContent")
     * @var ResponseContent
     */
    private $responseContent;

    public function __construct()
    {
        $this->version           = '1.0';
        $this->sessionAttributes = [];
        $this->responseContent   = new ResponseContent();
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getSessionAttributes()
    {
        return $this->sessionAttributes;
    }

    /**
     * @param mixed $sessionAttributes
     */
    public function setSessionAttributes(array $sessionAttributes)
    {
        $this->sessionAttributes = $sessionAttributes;
    }

    /**
     * @return ResponseContent
     */
    public function getResponseContent()
    {
        return $this->responseContent;
    }

    /**
     * @param ResponseContent $responseContent
     */
    public function setResponseContent(ResponseContent $responseContent)
    {
        $this->responseContent = $responseContent;
    }

    /**
     * Convenience method, delegated to inner ResponseContent object
     *
     * @param bool $shouldEndSession
     */
    public function setShouldEndSession($shouldEndSession)
    {
        $this->responseContent->setShouldEndSession($shouldEndSession);
    }

    /**
     * Convenience method, delegated to inner ResponseContent object
     *
     * @return bool
     */
    public function shouldEndSession()
    {
        return $this->responseContent->shouldEndSession();
    }

    /**
     * Convenience method, delegated to inner ResponseContent object
     *
     * @param OutputSpeech $outputSpeech
     */
    public function setOutputSpeech(OutputSpeech $outputSpeech)
    {
        $this->responseContent->setOutputSpeech($outputSpeech);
    }

    /**
     * Convenience method, delegated to inner ResponseContent object
     *
     * @return OutputSpeech
     */
    public function getOutputSpeech()
    {
        return $this->responseContent->getOutputSpeech();
    }

    /**
     * Convenience method, delegated to inner ResponseContent object
     *
     * @param Card $card
     */
    public function setCard(Card $card)
    {
        $this->responseContent->setCard($card);
    }

    /**
     * Convenience method, delegated to inner ResponseContent object
     *
     * @return Card $card
     */
    public function getCard()
    {
        return $this->responseContent->getCard();
    }

    /**
     * Convenience method, delegated to inner ResponseContent object
     *
     * @param OutputSpeech $outputSpeech
     */
    public function setRepromptOutputSpeech(OutputSpeech $outputSpeech)
    {
        $this
            ->responseContent
            ->setReprompt(new Reprompt($outputSpeech))
        ;
    }

    /**
     * Convenience method, delegated to inner ResponseContent object
     *
     * @return OutputSpeech
     */
    public function getRepromptOutputSpeech()
    {
        $reprompt = $this->responseContent->getReprompt();
        if (!$reprompt) {
            return null;
        }

        return $reprompt->getOutputSpeech();
    }
}
