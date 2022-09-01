<?php

namespace NotificationChannels\PushSMS;

use Illuminate\Notifications\Notification;
use NotificationChannels\PushSMS\Exceptions\CouldNotSendNotification;
use NotificationChannels\PushSMS\PushSmsMessage;

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
        if (!($to = $this->getRecipients($notifiable, $notification))) {
            return null;
        }

        $message = $notification->{'toPushSms'}($notifiable);

        if (\is_string($message)) {
            $message = new PushSmsMessage($message);
        }

        return $this->sendMessage($to, $message);
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

        if (empty($to)) {
            return [];
        }

        return \is_array($to) ? $to : [$to];
    }

    protected function sendMessage($recipients, PushSmsMessage $message)
    {
        if (\mb_strlen($message->content) > 800) {
            throw CouldNotSendNotification::contentLengthLimitExceeded();
        }

        if (count($recipients) > 1) {
            $params = [
                'phones_numbers' => implode(',', $recipients),
                'text'           => $message->content,
            ];
        } else {
            $params = [
                'phone' => $recipients[0],
                'text'  => $message->content,
            ];
        }

        return $this->pushsms->send($params);
    }
}
