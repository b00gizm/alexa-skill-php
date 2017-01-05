<?php

namespace Alexa\Handler;

use Alexa\Alexa;
use Alexa\Intent;
use Alexa\Request\IntentRequest;
use Alexa\Response;
use Alexa\Session;

class IntentCallbackHandler implements IntentHandlerInterface
{
    /**
     * @var \Closure
     */
    private $callback;

    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Handles requests of type 'IntentRequest' and should either return a
     * Response object or null if it cannot handle the request
     *
     * @param Alexa $alexa
     * @param Intent $intent
     * @param IntentRequest $request
     * @param Session $session
     *
     * @return null|Response
     */
    public function handle(Alexa $alexa, Intent $intent, IntentRequest $request, Session $session)
    {
        $callback = $this->callback;

        return $callback($alexa, $intent, $request, $session);
    }
}
