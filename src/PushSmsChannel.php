<?php

namespace NotificationChannels\PushSMS;

use Illuminate\Notifications\Notification;
use NotificationChannels\PushSMS\ApiActions\PushSmsMessage;
use NotificationChannels\PushSMS\Exceptions\CouldNotSendNotification;

class PushSmsChannel
{
    /** @var PushSmsApi */
    protected $pushsms;

    public function __construct(PushSmsApi $pushsms)
    {
        $this->pushsms = $pushsms;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return array|null
     * @throws CouldNotSendNotification
     *
     */
    public function send($notifiable, Notification $notification): ?array
    {

        $result = null;
        $to = $this->getRecipients($notifiable, $notification);
        if ($to) {

            $message = PushSmsMessage::create()
                ->setContent($notification->{'toPushSms'}($notifiable))
                ->setRecipients($to);

            $result = $this->pushsms->send($message);
        }

        return $result;

    }

    /**
     * Gets a list of phones from the given notifiable.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return string[]
     */
    protected function getRecipients($notifiable, Notification $notification): array
    {
        $to = $notifiable->routeNotificationFor('pushsms', $notification);

        $result = \is_array($to) ? $to : [$to];

        if (empty($to)) {
            $result = [];
        }
        return $result;
    }

}
