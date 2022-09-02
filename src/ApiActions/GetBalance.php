<?php


namespace NotificationChannels\PushSMS\ApiActions;


class GetBalance extends CoreApiAction
{


    public function getMethod(): string
    {
        return 'GET';
    }

    public function getEndpoint(): string
    {
        return '/api/v1/account';
    }

    public function getParams(): array
    {
        return [];
    }

    public function validate(): bool
    {
        return true;
    }
}
