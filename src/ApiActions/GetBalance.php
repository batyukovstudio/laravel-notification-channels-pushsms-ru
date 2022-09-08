<?php


namespace NotificationChannels\PushSMS\ApiActions;

class GetBalance extends CoreApiAction
{
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return '/api/v1/account';
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [];
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return true;
    }
}
