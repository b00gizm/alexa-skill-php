<?php

namespace Alexa\Handler;

use Alexa\Alexa;
use Alexa\Request\LaunchRequest;
use Alexa\Response;
use Alexa\Session;

class LaunchCallbackHandler implements LaunchHandlerInterface
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
     * Handles requests of type 'LaunchRequest' and should either return a
     * Response object or null if it cannot handle the request
     *
     * @param Alexa $alexa
     * @param LaunchRequest $request
     * @param Session $session
     * @return null|Response
     */
    public function handle(Alexa $alexa, LaunchRequest $request, Session $session)
    {
        $callback = $this->callback;

        return $callback($alexa, $request, $session);
    }
}
