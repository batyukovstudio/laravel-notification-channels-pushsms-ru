<?php


namespace NotificationChannels\PushSMS;

/**
 * Class ServiceStatuses
 * @package NotificationChannels\PushSMS
 *
 * https://docs.pushsms.ru/#/statuses
 */
class ServiceStatuses
{

    /**
     * Ошибка оператора
     */
    public const TELECOMMUNICATIONS_COMPANY_ERROR = 0;

    /**
     * Передано оператору
     */
    public const ENROUTE = 1;

    /**
     * Доставлено
     */
    public const DELIVERED = 2;

    /**
     * Просрочено
     */
    public const EXPIRED = 3;

    /**
     * Удалено
     */
    public const DELETED = 4;

    /**
     * Невозможно доставить. Абонент отключен
     */
    public const UNDELIVERABLE = 5;

    /**
     * Принято
     */
    public const ACCEPTED = 6;

    /**
     * Неизвестная ошибка
     */
    public const UNKNOWN = 7;

    /**
     * Отклонено. Отказано в отправке
     */
    public const REJECTED = 8;

    /**
     * Внутренняя ошибка сервера
     */
    public const INTERNAL_SERVER_ERROR = 9;

    /**
     * Необрабатываемая ошибка
     */
    public const UNHANDLED_ERROR = 10;

    /**
     * Неверный номер
     */
    public const INCORRECT_NUMBER = 11;

    /**
     * Запрещено
     */
    public const FORBIDDEN = 12;

    /**
     * Недостаточно средств
     */
    public const NOT_ENOUGH_MONEY = 13;

    /**
     * Ожидается отправки
     */
    public const WAITING_FOR_SENDING = 14;

    /**
     * В обработке
     */
    public const IN_PROGRESS = 15;

    /**
     * На модерации
     */
    public const MODERATING = 21;

    /**
     * Модерация отклонена
     */
    public const MODERATION_DECLINED = 22;

    /**
     * Ограничение отправки
     */
    public const EXTERNAL_RESTRICTION = 25;

    /**
     * Законодательное ограничение отправки в Казахстан
     */
    public const KAZAKHSTAN_RESTRICTION = 27;

    /**
     * Ошибка при проведении платежной транзакции
     */
    public const PAYMENT_TRANSACTION_ERROR = 31;

    /**
     * Мессенджер не оплачен
     */
    public const WA_UNPAID = 32;

    /**
     * Невалидные параметры запроса на отправку
     */
    public const INCORRECT_DELIVERY_PARAMS = 33;

    /**
     * У аккаунта отключена международная отправка
     */
    public const FOREIGN_DELIVERY_RESTRICTED = 34;

    /**
     * Черный список
     */
    public const BLACKLIST_NUMBER_ERROR = 555;


}
