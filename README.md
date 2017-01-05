# alexa-skill-php

[![Build Status](https://travis-ci.org/b00giZm/alexa-skill-php.svg?branch=master)](https://travis-ci.org/b00giZm/alexa-skill-php)

OOP wrappers for the Amazon [Alexa Skill JSON interface](https://developer.amazon.com/public/solutions/alexa/alexa-skills-kit/docs/alexa-skills-kit-interface-reference).

## Install via Composer

```bash
composer require b00gizm/alexa-skill-php
```

## Example

### Quickstart

Your first Alexa app in less than 10 lines of code!

```php
$factory = new Alexa\EventFactory();
$alexa = new Alexa\Alexa($factory);
$alexa->onLaunchRequest(function(Alexa\Alexa $alexa, Alexa\LaunchRequest $request, Alexa\Session $session) {
    return $alexa->getResponse()->addPlainTextOutputSpeech("Welcome to my awesome app!");
});

return new JsonResponse($alexa->process($requestJson));
```

The `Alexa\Alexa` class contains several callback handlers to handle the different Alexa request types:

```php
$alexa->onLaunchRequest(function(Alexa\Alexa $alexa, Alexa\LaunchRequest $request, Alexa\Session $session) { ... });
$alexa->onIntentRequest(function(Alexa\Alexa $alexa, Alexa\Intent $intent, Alexa\LaunchRequest $request, Alexa\Session $session) { ... });
$alexa->onSessionEndedRequest(function(Alexa\Alexa $alexa, Alexa\LaunchRequest $request, Alexa\Session $session) { ... });
```

Your callbacks should either return a valid `Alexa\Response` or `NULL` if it does not know how to handle a request (more on that later).

### Writing Your Own Handlers

A more sophisticated way to provide Alexa request handlers is to write own handler classes which implement one (or more) of the following interfaces:

* `Alexa\Handler\LaunchRequestHandler`
* `Alexa\Handler\IntentRequestHandler`
* `Alexa\Handler\SessionEndedHandler`

Own request handlers must be registered with a `Alexa\EventProcessor` instance:

```php
$factory = new Alexa\EventFactory();

$processor = new Alexa\EventProcessor();
$processor->setLaunchHandler(new MyLaunchHandler());
$processor->setIntentHandlers([
    new MyFooIntentHandler(),
    new MyBarIntentHandler(),
]);
$processor->setSessionEndedHandler(new MySessionEndedHandler());

$alexa = new Alexa\Alexa($factory, $processor);
```

You may have noticed that there is an array of intent handlers. When writing bigger apps with lots of intents, writing a custom handler for each intent may be the best solution to organize your code base and maintain testability.

Intent handlers are processed in the order as they come in. If a handler cannot handle a certain intent request, it should simply return `NULL` to notify the processor to try the next intent handler. When an intent request could be handled successfully, it should return a valid `Alexa\Response` object signal the processor that it should stop.

**Please keep in mind that `Alexa\Alexa`'s callback handlers will be always be preferred and _will override your registered custom handlers_ if you try to use both at once for some reason.**

## Autoloading

This library uses [schmittjoh/serializer](https://github.com/schmittjoh/serializer) for serializing and deserializung, which itself relies on [doctrine/common](https://github.com/doctrine/common) for annotation support. If you're getting weird serializer errors, please append this to your `autolad.php` as a work around for the moment:

```php
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
```

## Maintainer

Pascal Cremer

* Email: <hello@codenugget.co>
* Twitter: [@b00gizm](https://twitter.com/b00gizm)
* Web: [http://codenugget.co](http://codenugget.co)

## License

> The MIT License (MIT)
>
> Copyright (c) 2016-2017 Pascal Cremer
>
>Permission is hereby granted, free of charge, to any person obtaining a copy
>of this software and associated documentation files (the "Software"), to deal
>in the Software without restriction, including without limitation the rights
>to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
>copies of the Software, and to permit persons to whom the Software is
>furnished to do so, subject to the following conditions:
>
>The above copyright notice and this permission notice shall be included in all
>copies or substantial portions of the Software.
>
>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
>IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
>FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
>AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
>LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
>OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
>SOFTWARE.