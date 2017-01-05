<?php

namespace Alexa\Request;

use Alexa\Intent;
use Alexa\Request;
use JMS\Serializer\Annotation\Type;

class IntentRequest extends Request
{
    /**
     * @Type("Alexa\Intent")
     * @var Intent
     */
    private $intent;

    /**
     * @return Intent
     */
    public function getIntent()
    {
        return $this->intent;
    }

    /**
     * @param Intent $intent
     */
    public function setIntent(Intent $intent)
    {
        $this->intent = $intent;
    }
}
