<?php

namespace Alexa;

use Alexa\Exception\InvalidArgumentException;
use Alexa\Exception\LogicException;
use Alexa\Handler\IntentHandlerInterface;
use Alexa\Handler\LaunchHandlerInterface;
use Alexa\Handler\SessionEndedHandlerInterface;
use Alexa\Request\IntentRequest;
use Alexa\Request\LaunchRequest;
use Alexa\Request\SessionEndedRequest;

class EventProcessor implements EventProcessorInterface
{
    /**
     * @var LaunchHandlerInterface
     */
    private $launchHandler;

    /**
     * @var array
     */
    private $intentHandlers;

    /**
     * @var SessionEndedHandlerInterface
     */
    private $sessionEndedHandler;

    public function __construct()
    {
        $this->intentHandlers = [];
    }

    /**
     * Processes a Alexa event object and must return a valid Alexa response object
     *
     * @param Alexa $alexa
     * @param Event $event
     *
     * @return Response
     */
    public function process(Alexa $alexa, Event $event)
    {
        switch ($event->getRequest()->getType()) {
            case Request::TYPE_LAUNCH:
                if (!$this->launchHandler) {
                    return new Response();
                }

                /** @var LaunchRequest $request */
                $request = $event->getRequest();

                $response = $this
                    ->launchHandler
                    ->handle($alexa, $request, $event->getSession())
                ;

                return $response ?: new Response();

            case Request::TYPE_INTENT:
                $response = null;
                /** @var IntentHandlerInterface $handler */
                foreach ($this->intentHandlers as $handler) {
                    if (!($handler instanceof IntentHandlerInterface)) {
                        throw new LogicException(sprintf(
                            "Intent handler of wrong type '%s'",
                            get_class($handler)
                        ));
                    }

                    /** @var IntentRequest $request */
                    $request = $event->getRequest();
                    $response = $handler->handle(
                        $alexa,
                        $request->getIntent(),
                        $request,
                        $event->getSession()
                    );

                    if ($response) {
                        break;
                    }
                }

                return $response ?: new Response();
            case Request::TYPE_SESSION_ENDED:
                if (!$this->sessionEndedHandler) {
                    return new Response();
                }

                /** @var SessionEndedRequest $request */
                $request = $event->getRequest();

                $response = $this
                    ->sessionEndedHandler
                    ->handle($alexa, $request, $event->getSession())
                ;

                return $response ?: new Response();
            default:
                throw new InvalidArgumentException(sprintf(
                    "Invalid request type '%s' during event processing",
                    $event->getRequest()->getType()
                ));
        }
    }

    /**
     * @return LaunchHandlerInterface
     */
    public function getLaunchHandler()
    {
        return $this->launchHandler;
    }

    /**
     * @param LaunchHandlerInterface $launchHandler
     */
    public function setLaunchHandler(LaunchHandlerInterface $launchHandler)
    {
        $this->launchHandler = $launchHandler;
    }

    /**
     * @return array
     */
    public function getIntentHandlers()
    {
        return $this->intentHandlers;
    }

    /**
     * @param array $intentHandlers
     */
    public function setIntentHandlers(array $intentHandlers)
    {
        $this->intentHandlers = $intentHandlers;
    }

    /**
     * Prepends a new intent handler to the beginning of the
     * intent handlers array
     *
     * @param IntentHandlerInterface $intentHandler
     */
    public function prependIntentHandler(IntentHandlerInterface $intentHandler)
    {
        array_unshift($this->intentHandlers, $intentHandler);
    }

    /**
     * Appends a new intent handler to the end of the
     * intent handlers array
     *
     * @param IntentHandlerInterface $intentHandler
     */
    public function appendIntentHandler(IntentHandlerInterface $intentHandler)
    {
        array_push($this->intentHandlers, $intentHandler);
    }

    /**
     * @return SessionEndedHandlerInterface
     */
    public function getSessionEndedHandler()
    {
        return $this->sessionEndedHandler;
    }

    /**
     * @param SessionEndedHandlerInterface $sessionEndedHandler
     */
    public function setSessionEndedHandler(SessionEndedHandlerInterface $sessionEndedHandler)
    {
        $this->sessionEndedHandler = $sessionEndedHandler;
    }
}
