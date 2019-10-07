<?php

namespace NotificationChannels\JetSms\Test\Events;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Erdemkeren\JetSms\ShortMessageCollection;
use NotificationChannels\JetSms\Events\MessagesWereSent;
use Erdemkeren\JetSms\Http\Responses\JetSmsResponseInterface;

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
