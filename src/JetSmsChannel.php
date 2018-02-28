<?php

namespace NotificationChannels\JetSms;

use Erdemkeren\JetSms\ShortMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\JetSms\Exceptions\CouldNotSendNotification;

/**
 * Class JetSmsChannel.
 */
final class JetSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @throws \NotificationChannels\JetSms\Exceptions\CouldNotSendNotification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toJetSms($notifiable);

        if ($message instanceof ShortMessage) {
            JetSms::sendShortMessage($message);

            return;
        }

        $to = $notifiable->routeNotificationFor('JetSms');

        if (empty($to)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        JetSms::sendShortMessage($to, $message);
    }
}
