<?php

namespace Alexa\Handler;

use Alexa\Alexa;
use Alexa\Request\SessionEndedRequest;
use Alexa\Response;
use Alexa\Session;

class SessionEndedCallbackHandler implements SessionEndedHandlerInterface
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
     * Handles requests of type 'SessionEndedRequest' and should either return a
     * Response object or null if it cannot handle the request
     *
     * @param Alexa $alexa
     * @param SessionEndedRequest $request
     * @param Session $session
     * @return Response|null
     */
    public function handle(Alexa $alexa, SessionEndedRequest $request, Session $session)
    {
        $callback = $this->callback;

        return $callback($alexa, $request, $session);
    }
}
