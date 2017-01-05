<?php

namespace Alexa\Handler;

use Alexa\Alexa;
use Alexa\Request\LaunchRequest;
use Alexa\Response;
use Alexa\Session;

interface LaunchHandlerInterface extends HandlerInterface
{
    /**
     * Handles requests of type 'LaunchRequest' and should either return a
     * Response object or null if it cannot handle the request
     *
     * @param Alexa $alexa
     * @param LaunchRequest $request
     * @param Session $session
     * @return Response|null
     */
    public function handle(Alexa $alexa, LaunchRequest $request, Session $session);
}
