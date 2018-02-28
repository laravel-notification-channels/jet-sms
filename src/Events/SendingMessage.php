<?php

namespace NotificationChannels\JetSms\Events;

use Erdemkeren\JetSms\ShortMessage;

/**
 * Class SendingMessage.
 */
class SendingMessage
{
    /**
     * The JetSms message.
     *
     * @var ShortMessage
     */
    public $message;

    /**
     * SendingMessage constructor.
     *
     * @param $message
     */
    public function __construct(ShortMessage $message)
    {
        $this->message = $message;
    }
}
