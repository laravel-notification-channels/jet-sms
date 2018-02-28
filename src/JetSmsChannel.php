<?php

namespace NotificationChannels\JetSms;

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
        $to = $notifiable->routeNotificationFor('JetSms');

        if (empty($to)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        $message = $notification->toJetSms($notifiable);

        JetSms::sendShortMessage($to, $message);
    }
}
