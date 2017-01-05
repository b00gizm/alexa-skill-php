<?php

namespace Alexa;

interface EventProcessorInterface
{
    /**
     * Processes a Alexa event object and must return a valid Alexa response object
     *
     * @param Alexa $alexa
     * @param Event $event
     *
     * @return Response
     */
    public function process(Alexa $alexa, Event $event);
}