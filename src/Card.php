<?php

namespace Alexa;

use JMS\Serializer\Annotation\Discriminator;
use JMS\Serializer\Annotation\Type;

/**
 * @Discriminator(field="type", map={
 *     "Simple":"Alexa\Card\SimpleCard",
 *     "Standard":"Alexa\Card\StandardCard",
 *     "LinkedAccount":"Alexa\Card\LinkedAccountCard"
 * })
 */
abstract class Card
{
}
