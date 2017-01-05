<?php

namespace Alexa\OutputSpeech;

use Alexa\OutputSpeech;
use JMS\Serializer\Annotation\Type;

class PlainTextOutputSpeech extends OutputSpeech
{
    /**
     * @Type("string")
     * @var string
     */
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}
