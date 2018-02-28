<?php

namespace NotificationChannels\JetSms\Events;

use Erdemkeren\JetSms\ShortMessageCollection;

/**
 * Class SendingMessages.
 */
class SendingMessages
{
    /**
     * The JetSms message.
     *
     * @var ShortMessageCollection
     */
    public $messages;

    /**
     * SendingMessage constructor.
     *
     * @param  ShortMessageCollection $messages
     */
    public function __construct(ShortMessageCollection $messages)
    {
        $this->messages = $messages;
    }
}
