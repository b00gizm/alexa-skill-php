<?php

namespace Alexa;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class Session
{
    /**
     * @SerializedName("sessionId")
     * @Type("string")
     * @var string
     */
    private $id;

    /**
     * @SerializedName("new")
     * @Accessor(getter="isNew",setter="setNew")
     * @Type("boolean")
     * @var bool
     */
    private $isNew;

    /**
     * @Type("array<string,string>")
     * @var array
     */
    private $application;

    /**
     * @Type("array<string,string>")
     * @var array
     */
    private $user;

    /**
     * @Type("array<string,array>")
     * @var array
     */
    private $attributes;

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
     * @return boolean
     */
    public function isNew()
    {
        return $this->isNew;
    }

    /**
     * @param boolean $isNew
     */
    public function setNew($isNew)
    {
        $this->isNew = $isNew;
    }

    /**
     * @return array
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param array $application
     */
    public function setApplication(array $application)
    {
        $this->application = $application;
    }

    /**
     * @return null|string
     */
    public function getApplicationId()
    {
        if (!$this->application) {
            return null;
        }

        return isset($this->application['applicationId']) ?
            $this->application['applicationId'] :
            null
        ;
    }

    /**
     * @return array
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param array $user
     */
    public function setUser(array $user)
    {
        $this->user = $user;
    }

    /**
     * @return null|string
     */
    public function getUserId()
    {
        if (!$this->user) {
            return null;
        }

        return isset($this->user['userId']) ?
            $this->user['userId'] :
            null
        ;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasAttribute($name)
    {
        return isset($this->attributes[$name]);
    }

    /**
     * @param $name
     *
     * @return null|string
     */
    public function getAttribute($name)
    {
        if (!$this->hasAttribute($name)) {
            return null;
        }

        return $this->attributes[$name];
    }
}
