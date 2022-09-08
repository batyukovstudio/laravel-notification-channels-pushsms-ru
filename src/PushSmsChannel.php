<?php

namespace NotificationChannels\PushSMS;

use GuzzleHttp\Exception\GuzzleException;
use NotificationChannels\PushSMS\Exceptions\CouldNotSendNotification;
use NotificationChannels\PushSMS\Notifications\Interfaces\PushSmsable;

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
     * @param PushSmsable $notification
     * @return array|null
     * @throws CouldNotSendNotification
     * @throws GuzzleException
     */
    public function send($notifiable, PushSmsable $notification): ?array
    {
        $result = null;
        $to     = $this->getRecipients($notifiable, $notification);

        if ($to) {
            $message = $notification->toPushSms($notifiable);
            $message->setRecipients($to);

            $result = $this->pushsms->send($message);
        }

        return $result;
    }

    /**
     * Gets a list of phones from the given notifiable.
     *
     * @param $notifiable
     * @param PushSmsable $notification
     * @return array
     */
    protected function getRecipients($notifiable, PushSmsable $notification): array
    {
        $to = $notifiable->routeNotificationFor('pushsms', $notification);

        $result = \is_array($to) ? $to : [$to];

        if (empty($to)) {
            $result = [];
        }
        return $result;
    }

}
