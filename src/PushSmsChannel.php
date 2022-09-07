<?php

namespace NotificationChannels\PushSMS;

use GuzzleHttp\Exception\GuzzleException;
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
     * @param $notifiable
     * @param Notification $notification
     * @return array|null
     * @throws CouldNotSendNotification
     * @throws GuzzleException
     */
    public function send($notifiable, Notification $notification): ?array
    {
        $result = null;
        $to     = $this->getRecipients($notifiable, $notification);

        if ($to) {
            $message = $notification->{'toPushSms'}($notifiable);

            if (is_string($message)) {
                $message = PushSmsMessage::create()
                    ->setContent($message)
                    ->setRecipients($to);
            } else {
                $message->setRecipients($to);
            }

            $result = $this->pushsms->send($message);
        }

        return $result;
    }

    /**
     * Gets a list of phones from the given notifiable.
     *
     * @param $notifiable
     * @param Notification $notification
     * @return array
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
