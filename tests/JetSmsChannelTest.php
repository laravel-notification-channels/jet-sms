<?php

namespace NotificationChannels\JetSms\Test;

use Erdemkeren\JetSms\Http\Responses\JetSmsResponseInterface;
use Erdemkeren\JetSms\ShortMessage;
use Exception;
use Illuminate\Notifications\Notification;
use Mockery as M;
use NotificationChannels\JetSms\Exceptions\CouldNotSendNotification;
use NotificationChannels\JetSms\JetSms;
use NotificationChannels\JetSms\JetSmsChannel;
use PHPUnit\Framework\TestCase;

class JetSmsChannelTest extends TestCase
{
    /**
     * @var JetSmsChannel
     */
    private $channel;

    /**
     * @var JetSmsResponseInterface
     */
    private $responseInterface;

    public function setUp(): void
    {
        parent::setUp();

        $this->channel = new JetSmsChannel();
        $this->responseInterface = M::mock(JetSmsResponseInterface::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_it_sends_notification()
    {
        JetSms::shouldReceive('sendShortMessage')
            ->once()
            ->with('+1234567890', 'foo')
            ->andReturn($this->responseInterface);

        $this->assertNull($this->channel->send(new TestNotifiable(), new TestNotification()));
    }

    public function test_it_sends_notification_with_short_message()
    {
        $message = new TestNotificationWithShortMessage();

        JetSms::shouldReceive('sendShortMessage')
            ->once()
            ->andReturn($this->responseInterface);

        $this->assertNull($this->channel->send(new TestNotifiable(), $message));
    }

    public function test_it_throws_exception_if_no_receiver_provided()
    {
        $e = null;

        try {
            $this->channel->send(new EmptyTestNotifiable(), new TestNotification());
        } catch (Exception $e) {
        }

        $this->assertInstanceOf(CouldNotSendNotification::class, $e);
    }
}

class TestNotifiable
{
    public function routeNotificationFor()
    {
        return '+1234567890';
    }
}

class TestNotification extends Notification
{
    public function via($notifiable)
    {
        return [JetSmsChannel::class];
    }

    public function toJetSms($notifiable)
    {
        return 'foo';
    }
}

class TestNotificationWithShortMessage extends Notification
{
    public function via($notifiable)
    {
        return [JetSmsChannel::class];
    }

    public function toJetSms($notifiable)
    {
        return new ShortMessage('foo', 'bar');
    }
}

class EmptyTestNotifiable
{
    public function routeNotificationFor()
    {
        return '';
    }
}
