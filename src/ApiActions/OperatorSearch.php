<?php


namespace NotificationChannels\PushSMS\ApiActions;

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
        return '/api/v1/operators/search';
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'phone' => $this->phone
        ];
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return true;
    }
}
