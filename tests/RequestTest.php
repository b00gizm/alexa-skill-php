<?php

namespace Tests\Alexa;

use Alexa\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testIsType()
    {
        $request = new Request();
        $request->setType(Request::TYPE_LAUNCH);

        $this->assertTrue($request->isType(Request::TYPE_LAUNCH));
    }
}
