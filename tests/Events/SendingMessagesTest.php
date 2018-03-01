<?php

namespace NotificationChannels\JetSms\Test\Events;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Erdemkeren\JetSms\ShortMessageCollection;
use NotificationChannels\JetSms\Events\SendingMessages;

class SendingMessagesTest extends TestCase
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
        $shortMessageCollection = M::mock(ShortMessageCollection::class);

        $event = new SendingMessages($shortMessageCollection);

        $this->assertInstanceOf(SendingMessages::class, $event);
        $this->assertEquals($shortMessageCollection, $event->messages);
    }
}
