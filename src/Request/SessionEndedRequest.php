<?php

namespace Alexa\Request;

use Alexa\Request;
use JMS\Serializer\Annotation\Type;

class SessionEndedRequest extends Request
{
    const REASON_USER_INITIATED         = 'USER_INITIATED';
    const REASON_ERROR                  = 'ERROR';
    const REASON_EXCEEDED_MAX_REPROMPTS = 'EXCEEDED_MAX_REPROMPTS';

    /**
     * @Type("string")
     * @var string
     */
    private $reason;

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }
}
