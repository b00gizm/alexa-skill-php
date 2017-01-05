<?php

namespace Tests\Alexa;

use Alexa\Session;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testApplicationId()
    {
        $session = new Session();
        $session->setApplication(['applicationId' => 'abc123']);

        $this->assertEquals('abc123', $session->getApplicationId());
    }

    public function testUserId()
    {
        $session = new Session();
        $session->setUser(['userId' => 'def456']);

        $this->assertEquals('def456', $session->getUserId());
    }

    public function testHasAttributes()
    {
        $session = new Session();
        $session->setAttributes([
            'foo' => 123,
            'bar' => 456,
        ]);

        $this->assertTrue($session->hasAttribute('foo'));
        $this->assertFalse($session->hasAttribute('baz'));
    }

    public function testGetAttribute()
    {
        $session = new Session();
        $session->setAttributes([
            'foo' => 123,
            'bar' => 456,
        ]);

        $this->assertEquals(123, $session->getAttribute('foo'));
        $this->assertNull($session->getAttribute('baz'));
    }
}
