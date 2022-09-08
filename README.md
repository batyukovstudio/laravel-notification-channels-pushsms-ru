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

Add your PushSms token to your `.env`:

```php
// .env
...
PUSHSMS_TOKEN=qwerty123
```

## Usage

You need to replace `Notification` extend with `PushSmsNotification` class.
```php
namespace App\Notifications;

use NotificationChannels\PushSMS\Notifications\PushSmsNotification;

class MyNotification extends PushSmsNotification
{
    use Queueable;
    
    // ...
}
```
`PushSmsNotification` contains `$content` variable for your text message and `toPushSms` method. This method will receive a `$notifiable` entity and should return an `NotificationChannels\PushSMS\ApiActions\PushSmsMessage` instance:
```php
// PushSmsNotification
}
use Illuminate\Notifications\Notification;
use NotificationChannels\PushSMS\ApiActions\PushSmsMessage;
use NotificationChannels\PushSMS\Notifications\Interfaces\PushSmsable;

abstract class PushSmsNotification extends Notification implements PushSmsable
{
    protected string $content;

    public function toPushSms($notifiable): PushSmsMessage
    {
        return PushSmsMessage::create()->content($this->content);
    }
}

```

You can use the channel in your `via()` method inside the notification:

```php
namespace App\Notifications;

use NotificationChannels\PushSMS\Notifications\PushSmsNotification;
use NotificationChannels\PushSMS\PushSmsChannel;

class MyNotification extends PushSmsNotification
{
    public function via($notifiable)
    {
        return [PushSmsChannel::class];
    }
}
```

In your notifiable model, make sure to include a `routeNotificationForPushsms()` method, which returns a phone number
or an array of phone numbers.

```php
public function routeNotificationForPushsms()
{
    return $this->phone;
}
```

### Message method

`content()`: Set a content of the notification message.
