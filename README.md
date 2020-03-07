# JetSms Notification Channel For Laravel 5.3+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/jet-sms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/jet-sms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/jet-sms/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/jet-sms)
[![StyleCI](https://styleci.io/repos/74304440/shield?branch=master)](https://styleci.io/repos/74304440)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/jet-sms.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/jet-sms)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/jet-sms/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/jet-sms/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/jet-sms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/jet-sms)

This package makes it easy to send notifications using [JetSms](http://www.jetsms.net) with Laravel 5.5+, 6.x and 7.x.

## Contents

- [Installation](#installation)
    - [Setting up the JetSms service](#setting-up-the-jetSms-service)
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

### Setting up the JetSms service

Add your desired client, username, password, originator (outbox name, sender name) and request timeout
configuration to your `config/services.php` file:
                                                                     
```php
...
    'JetSms' => [
        'client'     => 'http', // or xml
        'http'       => [
            'endpoint' => 'https://service.jetsms.com.tr/SMS-Web/HttpSmsSend',
        ],
        'xml'        => [
            'endpoint' => 'www.biotekno.biz:8080/SMS-Web/xmlsms',
        ],
        'username'   => '',
        'password'   => '',
        'originator' => "", // Sender name.
        'timeout'    => 60,
    ],
...
```

## Usage

Now you can use the channel in your via() method inside the notification:

```php
use NotificationChannels\JetSms\JetSmsChannel;
use NotificationChannels\JetSms\JetSmsMessage;

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
        return [JetSmsChannel::class];
    }
    
    /**
     * Get the JetSms representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string|\NotificationChannels\JetSms\JetSmsMessage
     */
    public function toJetSms($notifiable) {
        return "Test notification";
        // Or
        return new ShortMessage($notifiable->phone_number, 'Test notification');
    }
}
```

Don't forget to place the dedicated method for JetSms inside your notifiables. (e.g. User)

```php
class User extends Authenticatable
{
    use Notifiable;
    
    public function routeNotificationForJetSms()
    {
        return "905123456789";
    }
}
```

### Available methods

JetSms can also be used directly to send short messages.

Examples:
```php
JetSms::sendShortMessage($to, $message);
JetSms::sendShortMessages([[
    'recipient' => $to,
    'message'   => $message,
], [
    'recipient' => $anotherTo,
    'message'   => $anotherMessage,
]]);
```

see: [jet-sms-php](https://github.com/erdemkeren/jet-sms-php) documentation for more information.

### Available events

JetSms Notification channel comes with handy events which provides the required information about the SMS messages.

1. **Message Was Sent** (`NotificationChannels\JetSms\Events\MessageWasSent`)
2. **Messages Were Sent** (`NotificationChannels\JetSms\Events\MessageWasSent`)
3. **Sending Message** (`NotificationChannels\JetSms\Events\SendingMessage`)
4. **Sending Messages** (`NotificationChannels\JetSms\Events\SendingMessages`)

Example:

```php
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\JetSms\Events\MessageWasSent;

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
        $message = $event->message;
    }
}
```

### Notes

$response->groupId() will throw BadMethodCallException if the client is set to 'http'. 
$response->messageReportIdentifiers() will throw BadMethodCallException if the client is set to 'xml'.

change client configuration with caution.

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
