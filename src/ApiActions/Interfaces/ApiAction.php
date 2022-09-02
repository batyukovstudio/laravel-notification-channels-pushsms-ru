<?php


namespace NotificationChannels\PushSMS\ApiActions\Interfaces;


interface ApiAction
{


    public function getMethod(): string;

    public function getEndpoint(): string;

    public function getParams(): array;

    public function validate(): bool;

}
