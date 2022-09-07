<?php


namespace NotificationChannels\PushSMS;

/**
 * Class ServiceStatusCallbacks
 * @package NotificationChannels\PushSMS
 *
 *
 * https://docs.pushsms.ru/#/callback_url
 */
class ServiceStatusCallbacks
{
    /**
     * Объект отправки
     */
    public const DELIVERY_OBJECT = 'delivery';

    /**
     * Имя отправителя отправки
     */
    public const DELIVERY_SENDER_NAME = 'delivery.sender_name';

    /**
     * Внутренний ID отправки
     */
    public const DELIVERY_ID = 'delivery.id';

    /**
     * Объект статуса
     */
    public const STATUS = 'status';

    /**
     * ID статуса из “Списка статусов”
     */
    public const STATUS_ID = 'status.status_id';

    /**
     * Краткое описание статуса
     */
    public const STATUS_DESCRIPTION = 'status.description';

}
