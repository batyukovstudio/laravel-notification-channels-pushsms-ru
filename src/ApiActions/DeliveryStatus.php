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
        return '/api/v1/delivery/' . $this->id;
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
