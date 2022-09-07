<?php


namespace NotificationChannels\PushSMS\ApiActions;


use NotificationChannels\PushSMS\ApiActions\Interfaces\ApiAction;

class DeliveryStatus extends CoreApiAction
{

    private $id;

    /**
     * @param mixed $id
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }


    public function getMethod(): string
    {
        return 'GET';
    }

    public function getEndpoint(): string
    {
        return '/api/v1/delivery/:id';
    }

    public function getParams(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    public function validate(): bool
    {
        return true;
    }
}
