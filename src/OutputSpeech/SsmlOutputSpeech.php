<?php

namespace Alexa\OutputSpeech;

use Alexa\OutputSpeech;
use JMS\Serializer\Annotation\Type;

class SsmlOutputSpeech extends OutputSpeech
{
    /**
     * @Type("string")
     * @var string
     */
    private $ssml;

    public function __construct($ssml)
    {
        $this->ssml = $ssml;
    }

    /**
     * @return string
     */
    public function getSsml()
    {
        return $this->ssml;
    }

    /**
     * @param string $ssml
     */
    public function setSsml($ssml)
    {
        $this->ssml = $ssml;
    }
}
