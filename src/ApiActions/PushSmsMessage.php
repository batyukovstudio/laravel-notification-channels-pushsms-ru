<?php

namespace NotificationChannels\PushSMS\ApiActions;

use NotificationChannels\PushSMS\ApiActions\Interfaces\ApiAction;
use NotificationChannels\PushSMS\Exceptions\CouldNotSendNotification;

class PushSmsMessage extends CoreApiAction
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
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param mixed $recipients
     */
    public function setRecipients($recipients): self
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * Set the message content.
     *
     * @param string $content
     * @return $this
     */
    public function content(string $content): PushSmsMessage
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

        if (count($recipients) > 1) {
            $result = '/api/v1/bulk_delivery';
        } else {
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
                'text'           => $this->content,
            ];
        } else {
            $params = [
                'phone' => $recipients[0],
                'text'  => $this->content,
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
