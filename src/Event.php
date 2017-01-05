<?php

namespace Alexa;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class Event
{
    /**
     * @Type("string")
     * @var string
     */
    private $version;

    /**
     * @Type("Alexa\Session")
     * @var Session
     */
    private $session;

    /**
     * @SerializedName("request")
     * @Type("Alexa\Request")
     * @var Request
     */
    private $request;

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
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setAttributes(Request $request)
    {
        $this->request = $request;
    }
}
