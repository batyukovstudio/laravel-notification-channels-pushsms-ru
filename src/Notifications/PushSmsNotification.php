<?php

namespace NotificationChannels\PushSMS\Notifications;

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
