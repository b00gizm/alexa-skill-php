<?php

namespace Alexa\Card;

use Alexa\Card;
use JMS\Serializer\Annotation\Type;

class SimpleCard extends Card
{
    /**
     * @Type("string")
     * @var string
     */
    private $title;

    /**
     * @Type("string")
     * @var string
     */
    private $content;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
