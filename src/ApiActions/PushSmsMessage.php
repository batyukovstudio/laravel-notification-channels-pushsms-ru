<?php

namespace NotificationChannels\PushSMS\ApiActions;

use NotificationChannels\PushSMS\ApiActions\Interfaces\ApiAction;
use NotificationChannels\PushSMS\Exceptions\CouldNotSendNotification;

class PushSmsMessage implements ApiAction
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content = '';

    public $recipients;

    /**
     * @param string $content
     * @param $recipients
     * @return static
     */
    public static function create(string $content = '', $recipients)
    {
        return new static($content, $recipients);
    }

    /**
     * PushSmsMessage constructor.
     * @param string $content
     * @param $recipients
     */
    public function __construct(string $content = '', $recipients)
    {
        $this->content = $content;
        $this->recipients = $recipients;
    }

    /**
     * Set the message content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        $recipients = $this->recipients;
        $result = '/api/v1/bulk_delivery';

        if (isset($recipients['phone'])) {
            $result = '/api/v1/delivery';
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        $recipients = $this->recipients;

        if (count($recipients) > 1) {
            $params = [
                'phones_numbers' => implode(',', $recipients),
                'text' => $this->content,
            ];
        } else {
            $params = [
                'phone' => $recipients[0],
                'text' => $this->content,
            ];
        }

        return [
            'form_params' => array_filter($params),
        ];
    }

    /**
     * @return bool
     * @throws CouldNotSendNotification
     */
    public function validate(): bool
    {
        if (\mb_strlen($this->content) > 800) {
            throw CouldNotSendNotification::contentLengthLimitExceeded();
        }
        return true;
    }
}
