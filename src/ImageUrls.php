<?php

namespace Alexa;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class ImageUrls
{
    /**
     * @SerializedName("smallImageUrl")
     * @Type("string")
     * @var string
     */
    private $smallImageUrl;

    /**
     * @SerializedName("largeImageUrl")
     * @Type("string")
     * @var string
     */
    private $largeImageUrl;

    /**
     * @return string
     */
    public function getSmallImageUrl()
    {
        return $this->smallImageUrl;
    }

    /**
     * @param string $smallImageUrl
     */
    public function setSmallImageUrl($smallImageUrl)
    {
        $this->smallImageUrl = $smallImageUrl;
    }

    /**
     * @return string
     */
    public function getLargeImageUrl()
    {
        return $this->largeImageUrl;
    }

    /**
     * @param string $largeImageUrl
     */
    public function setLargeImageUrl($largeImageUrl)
    {
        $this->largeImageUrl = $largeImageUrl;
    }
}
