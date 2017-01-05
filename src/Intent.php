<?php

namespace Alexa;

use JMS\Serializer\Annotation\Type;

class Intent
{
    /**
     * @Type("string");
     * @var string
     */
    private $name;

    /**
     * @Type("array<string,Alexa\Slot>")
     * @var array
     */
    private $slots;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getSlots()
    {
        return $this->slots;
    }

    /**
     * @param array $slots
     */
    public function setSlots(array $slots)
    {
        $this->slots = $slots;
    }
}
