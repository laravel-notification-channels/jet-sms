<?php

namespace NotificationChannels\JetSms;

use Erdemkeren\JetSms\ShortMessage;
use Illuminate\Support\Facades\Facade;
use Erdemkeren\JetSms\ShortMessageCollection;
use Erdemkeren\JetSms\Http\Responses\JetSmsResponseInterface;

/**
 * Class JetSms.
 *
 * @method static JetSmsResponseInterface sendShortMessage(array|string|ShortMessage $receivers, string|null $body = null)
 * @method static JetSmsResponseInterface sendShortMessages(array|ShortMessageCollection $messages)
 */
class JetSms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jet-sms';
    }
}
