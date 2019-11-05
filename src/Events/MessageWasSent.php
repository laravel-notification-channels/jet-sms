<?php

namespace NotificationChannels\JetSms\Events;

use Erdemkeren\JetSms\Http\Responses\JetSmsResponseInterface;
use Erdemkeren\JetSms\ShortMessage;

/**
 * Class MessageWasSent.
 */
class MessageWasSent
{
    /**
     * The sms message.
     *
     * @var ShortMessage
     */
    public $message;

    /**
     * The Api response implementation.
     *
     * @var JetSmsResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessage            $message
     * @param JetSmsResponseInterface $response
     */
    public function __construct(ShortMessage $message, JetSmsResponseInterface $response)
    {
        $this->message = $message;
        $this->response = $response;
    }
}
