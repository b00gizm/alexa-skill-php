<?php

namespace Alexa;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class Reprompt
{
    /**
     * @SerializedName("outputSpeech")
     * @Type("Alexa\OutputSpeech")
     * @var OutputSpeech
     */
    private $outputSpeech;

    public function __construct(OutputSpeech $outputSpeech)
    {
        $this->outputSpeech = $outputSpeech;
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
}
