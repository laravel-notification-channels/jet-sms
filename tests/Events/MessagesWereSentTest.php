<?php

namespace NotificationChannels\JetSms\Test\Events;

use Erdemkeren\JetSms\Http\Responses\JetSmsResponseInterface;
use Erdemkeren\JetSms\ShortMessageCollection;
use Mockery as M;
use NotificationChannels\JetSms\Events\MessagesWereSent;
use PHPUnit\Framework\TestCase;

class MessagesWereSentTest extends TestCase
{
    public function tearDown(): void
    {
        M::close();

        parent::tearDown();
    }

    public function test_it_constructs()
    {
        $shortMessageCollection = M::mock(ShortMessageCollection::class);
        $response = M::mock(JetSmsResponseInterface::class);

        $event = new MessagesWereSent($shortMessageCollection, $response);

        $this->assertInstanceOf(MessagesWereSent::class, $event);
        $this->assertEquals($shortMessageCollection, $event->messages);
        $this->assertEquals($response, $event->response);
    }
}
