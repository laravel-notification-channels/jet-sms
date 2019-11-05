<?php

namespace NotificationChannels\JetSms\Test\Events;

use Erdemkeren\JetSms\ShortMessageCollection;
use Mockery as M;
use NotificationChannels\JetSms\Events\SendingMessages;
use PHPUnit\Framework\TestCase;

class SendingMessagesTest extends TestCase
{
    public function tearDown(): void
    {
        M::close();

        parent::tearDown();
    }

    public function test_it_constructs()
    {
        $shortMessageCollection = M::mock(ShortMessageCollection::class);

        $event = new SendingMessages($shortMessageCollection);

        $this->assertInstanceOf(SendingMessages::class, $event);
        $this->assertEquals($shortMessageCollection, $event->messages);
    }
}
