<?php

namespace NotificationChannels\JetSms\Test\Events;

use Erdemkeren\JetSms\Http\Responses\JetSmsResponseInterface;
use Erdemkeren\JetSms\ShortMessage;
use Mockery as M;
use NotificationChannels\JetSms\Events\MessageWasSent;
use PHPUnit\Framework\TestCase;

class MessageWasSentTest extends TestCase
{
    public function tearDown(): void
    {
        M::close();

        parent::tearDown();
    }

    public function test_it_constructs()
    {
        $shortMessage = M::mock(ShortMessage::class);
        $response = M::mock(JetSmsResponseInterface::class);

        $event = new MessageWasSent($shortMessage, $response);

        $this->assertInstanceOf(MessageWasSent::class, $event);
        $this->assertEquals($shortMessage, $event->message);
        $this->assertEquals($response, $event->response);
    }
}
