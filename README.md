# JetSMS Notification Channel For Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/jet-sms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/jet-sms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/jet-sms/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/jet-sms)
[![StyleCI](https://styleci.io/repos/74304440/shield?branch=master)](https://styleci.io/repos/74304440)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/ce5f111f-1be4-4848-a87d-7b2570d153d4.svg?style=flat-square)](https://insight.sensiolabs.com/projects/ce5f111f-1be4-4848-a87d-7b2570d153d4)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/jet-sms.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/jet-sms)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/jet-sms/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/jet-sms/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/jet-sms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/jet-sms)

This package makes it easy to send notifications using [JetSMS](http://www.jetsms.net) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the JetSMS service](#setting-up-the-jetsms-service)
- [Usage](#usage)
    - [Available methods](#available-methods)
    - [Available events](#available-events)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:

``` bash
composer require laravel-notification-channels/jet-sms
```
Next add the service provider to your `config/app.php`:

```php
...
'providers' => [
    ...
    NotificationChannels\JetSMS\JetSMSServiceProvider::class,
],
...
```

### Setting up the JetSMS service

You will need to register to JetSMS to use this channel.

The configuration given by the JetSMS should be included within your `config/services.php` file:
                                                                     
```php
...
'JetSMS' => [
    'http'       => [
        'endpoint' => '',
    ],
    'username'   => '',
    'password'   => '',
    'originator' => '', // Sender name.
    'timeout'    => 60,
],
...
```

## Usage

Follow Laravel's [documentation](https://laravel.com/docs/master/notifications) to add the channel to your Notification class.

```php
use NotificationChannels\JetSMS\JetSMSChannel;
use NotificationChannels\JetSMS\JetSMSMessage;

class ResetPasswordWasRequested extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [JetSMSChannel::class];
    }
    
    /**
     * Get the JetSMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string|\NotificationChannels\JetSMS\JetSMSMessage
     */
    public function toJetSMS($notifiable) {
        return "Test notification";
        // Or
        return new JetSMSMessage("Test notification", $notifiable->phone_number);
    }
}
```

Don't forget to place the dedicated method for JetSMS inside your notifiables. (e.g. User)

```php
class User extends Authenticatable
{
    use Notifiable;
    
    public function routeNotificationForJetSMS()
    {
        return "905123456789";
    }
}
```

### Available methods

Check out the constructor signature of JetSMSMessage:

```php
public function __construct($content, $number, $originator = null, $sendDate = null);
```

If you both place the originator (Outbox name) to your configuration and
your JetSMSMessage instance, the outbox name set by the JetSMSMessage
instance will be valid.

### Available events

JetSMS Notification channel comes with two handy events which provides the required information about the SMS messages.

1. **Message Was Sent** (`NotificationChannels\JetSMS\Events\MessageWasSent`)

This event is fired shortly after the message is sent. An example handler is presented below:

```php
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\JetSMS\Events\MessageWasSent;

class SentMessageHandler
{
    /**
     * Handle the event.
     *
     * @param  MessageWasSent  $event
     * @return void
     */
    public function handle(MessageWasSent $event)
    {
        $response = $event->response;
        $message = $response->message;

        // The message properties.
        \Log::info($message->content());
        \Log::info($message->number());
        \Log::info($message->originator());
        \Log::info($message->sendDate());

        // Message as array.
        \Log::info($message->toArray());

        // API Response properties.
        \Log::info($response->isSuccess());
        \Log::info($response->errorCode());
        \Log::info($response->errorMessage());
        \Log::info($response->messageReportIdentifiers());
    }
}
```

2. **Sending Message** (`NotificationChannels\JetSMS\Events`)

This event is fired just before the send request. An example handler is presented below.

```php
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\JetSMS\Events\SendingMessage;

class SendingMessageHandler
{
    /**
     * Handle the event.
     *
     * @param  SendingMessage  $event
     * @return void
     */
    public function handle(SendingMessage $event)
    {
        $message = $response->message;

        // The message properties.
        \Log::info($message->content());
        \Log::info($message->number());
        \Log::info($message->originator());
        \Log::info($message->sendDate());

        // Message as array.
        \Log::info($message->toArray());
    }
}
```

### Notes

The JetSMS message is immutable. Once constructed, no way to mutate.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email erdemkeren@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Hilmi Erdem KEREN](https://github.com/erdemkeren)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
