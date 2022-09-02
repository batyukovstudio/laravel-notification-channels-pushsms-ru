<?php


namespace NotificationChannels\PushSMS\ApiActions\Interfaces;


interface ApiAction
{

    /**
     * @return string
     *
     * GET/POST/PATCH/DELETE
     */
    public function getMethod(): string;

    /**
     * @return string
     *
     * Ссылка на действие без указания домена
     * Пример: /link/for/something:id
     */
    public function getEndpoint(): string;

    /**
     * @return array
     *
     * Параметры для отправки, без токена авторизации
     */
    public function getParams(): array;

    /**
     * @return bool
     *
     * Валидация отправляемых данных
     */
    public function validate(): bool;

}
