<?php

namespace NotificationChannels\JetSms\Test\Events;

use Erdemkeren\JetSms\ShortMessage;
use Mockery as M;
use NotificationChannels\JetSms\Events\SendingMessage;
use PHPUnit\Framework\TestCase;

class SendingMessageTest extends TestCase
{
    public function tearDown(): void
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
