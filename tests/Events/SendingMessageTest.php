<?php

namespace NotificationChannels\JetSMS\Test\Events;

use Mockery as M;
use Erdemkeren\JetSms\ShortMessage;
use NotificationChannels\JetSms\Events\SendingMessage;

class SendingMessageTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        M::close();

        parent::tearDown();
    }

    public function test_it_constructs()
    {
        $shortMessage = M::mock(ShortMessage::class);

        $event = new SendingMessage($shortMessage);

        $this->assertInstanceOf(SendingMessage::class, $event);
        $this->assertEquals($shortMessage, $event->message);
    }
}