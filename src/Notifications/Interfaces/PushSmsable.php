<?php

namespace NotificationChannels\PushSMS\Notifications\Interfaces;

use NotificationChannels\PushSMS\ApiActions\PushSmsMessage;

interface PushSmsable
{
    public function toPushSms($notifiable): PushSmsMessage;
}
