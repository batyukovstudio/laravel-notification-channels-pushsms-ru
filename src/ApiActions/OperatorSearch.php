<?php


namespace NotificationChannels\PushSMS\ApiActions;


use NotificationChannels\PushSMS\ApiActions\Interfaces\ApiAction;

class OperatorSearch extends CoreApiAction
{

    private $phone;

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getEndpoint(): string
    {
        return '/api/v1/operators/search';
    }

    public function getParams(): array
    {
        return [
            'phone' => $this->phone
        ];
    }

    public function validate(): bool
    {
        return true;
    }
}
