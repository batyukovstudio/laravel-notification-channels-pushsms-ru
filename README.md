# PushSMS notifications channel for Laravel

This package makes it easy to send notifications using [pushsms.ru](https://pushsms.ru/) with Laravel.

## Contents

- [Installation](#installation)
    - [Setting up the PushSMS service](#setting-up-the-PushSms-service)
- [Usage](#usage)
    - [Message method](#message-method)


## Installation

Install this package with Composer:

```bash
composer require batyukovstudio/laravel-notification-channels-pushsms-ru
```

The service provider gets loaded automatically. Or you can do this manually:
```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\PushSMS\PushSmsServiceProvider::class,
],
```

### Setting up the PushSms service

Add your PushSms token to your `config/services.php`:

```php
// config/services.php
...
'pushsms' => [
    'token'  => env('PUSHSMS_TOKEN'),
],
...

// .env
...
PUSHSMS_TOKEN=qwerty123
```

## Usage

You can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\PushSMS\PushSmsMessage;
use NotificationChannels\PushSMS\PushSmsChannel;

class OrderStatusChanged extends Notification
{
    public function via($notifiable)
    {
        return [PushSmsChannel::class];
    }

    public function toPushSms($notifiable)
    {
        return PushSmsMessage::create("Order №{$notifiable->getKey()} is ready!");
    }
}
```

In your notifiable model, make sure to include a `routeNotificationForSmscru()` method, which returns a phone number
or an array of phone numbers.

```php
public function routeNotificationForPushsms()
{
    return $this->phone;
}
```

### Message method

`content()`: Set a content of the notification message.
