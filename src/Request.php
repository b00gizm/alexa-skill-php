<?php

namespace Alexa;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class Request
{
    const TYPE_INTENT        = 'IntentRequest';
    const TYPE_LAUNCH        = 'LaunchRequest';
    const TYPE_SESSION_ENDED = 'SessionEndedRequest';

    /**
     * @SerializedName("requestId")
     * @Type("string")
     * @var string
     */
    private $id;

    /**
     * @Type("string")
     * @var string
     */
    private $type;

    /**
     * @Type("DateTime")
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function isType($type)
    {
        return $type === $this->type;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
    }
}
