<?php

namespace NotificationChannels\JetSms\Events;

use Erdemkeren\JetSms\Http\Responses\JetSmsResponseInterface;
use Erdemkeren\JetSms\ShortMessageCollection;

/**
 * Class MessagesWereSent.
 */
class MessagesWereSent
{
    /**
     * The sms message.
     *
     * @var ShortMessageCollection
     */
    public $messages;

    /**
     * The Api response implementation.
     *
     * @var JetSmsResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessageCollection  $messages
     * @param JetSmsResponseInterface $response
     */
    public function __construct(ShortMessageCollection $messages, JetSmsResponseInterface $response)
    {
        $this->messages = $messages;
        $this->response = $response;
    }
}
