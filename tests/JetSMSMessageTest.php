<?php
/**
 * Author: Hilmi Erdem KEREN
 * Date: 18/11/2016
 * Time: 00:31.
 */

namespace NotificationChannels\JetSMS\Test;

use Carbon\Carbon;
use NotificationChannels\JetSMS\JetSMSMessage;
use NotificationChannels\JetSMS\JetSMSMessageInterface;

class JetSMSMessageTest extends \PHPUnit_Framework_TestCase
{
    private $smsMessage;

    /** @test */
    public function it_should_be_constructed()
    {
        $this->smsMessage = new JetSMSMessage('foo', 'bar', 'baz');
        $this->assertInstanceOf(JetSMSMessageInterface::class, $this->smsMessage);
    }

    /** @test */
    public function it_should_be_constructed_with_date()
    {
        $this->smsMessage = new JetSMSMessage('foo', 'bar', 'baz', Carbon::now());
        $this->assertInstanceOf(JetSMSMessageInterface::class, $this->smsMessage);
    }

    /** @test */
    public function it_should_be_constructed_with_string_date()
    {
        $this->smsMessage = new JetSMSMessage('foo', 'bar', 'baz', '2017-01-01 00:00:00');

        $this->assertInstanceOf(Carbon::class, $this->smsMessage->sendDate());
    }

    /** @test */
    public function it_should_return_properties()
    {
        $this->smsMessage = new JetSMSMessage($content = 'foo', $number = 'bar', $originator = 'baz', Carbon::now());
        $this->assertEquals($this->smsMessage->content, $content);
        $this->assertEquals($this->smsMessage->number, $number);
        $this->assertEquals($this->smsMessage->originator, $originator);
    }
}
