<?php

namespace Alexa\Card;

use Alexa\Card;
use Alexa\ImageUrls;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class StandardCard extends Card
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
    private $text;

    /**
     * @SerializedName("image")
     * @Type("Alexa\ImageUrls")
     * @var ImageUrls
     */
    private $imageUrls;

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

    /**
     * @return ImageUrls
     */
    public function getImageUrls()
    {
        return $this->imageUrls;
    }

    /**
     * @param ImageUrls $imageUrls
     */
    public function setImageUrls($imageUrls)
    {
        $this->imageUrls = $imageUrls;
    }
}
