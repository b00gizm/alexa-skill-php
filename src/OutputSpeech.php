<?php

namespace Alexa;

use JMS\Serializer\Annotation\Discriminator;

/**
 * @Discriminator(field="type", map={
 *     "PlainText":"Alexa\OutputSpeech\PlainTextOutputSpeech",
 *     "SSML":"Alexa\OutputSpeech\SsmlOutputSpeech"
 * })
 */
abstract class OutputSpeech
{
}
