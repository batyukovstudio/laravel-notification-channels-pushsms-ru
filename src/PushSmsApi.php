<?php

namespace NotificationChannels\PushSMS;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use NotificationChannels\PushSMS\ApiActions\DeliveryStatus;
use NotificationChannels\PushSMS\ApiActions\GetBalance;
use NotificationChannels\PushSMS\ApiActions\Interfaces\ApiAction;
use NotificationChannels\PushSMS\ApiActions\OperatorSearch;
use NotificationChannels\PushSMS\ApiActions\PushSmsMessage;
use NotificationChannels\PushSMS\Exceptions\CouldNotSendNotification;

class PushSmsApi
{
    /** @var HttpClient */
    protected $client;

    /** @var string */
    protected $token;

    /**
     * @var string
     */
    protected $domain = 'https://api.pushsms.ru';

    public function __construct(array $config = null)
    {
        if (null === $config) {
            $config = config('pushsms');
        }

        $this->token = Arr::get($config, 'access_token');

        $this->client = new HttpClient([
            'timeout' => $config['timeout'],
            'connect_timeout' => $config['connect_timeout'],
        ]);;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function prepareParams(array $params): array
    {
        if (!isset($params['headers'])) {
            $params['headers'] = [];
        }
        $params['headers']['Authorization'] = 'Bearer ' . $this->token;

        return $params;
    }


    private static function create(): self
    {
        return new self();
    }


    public static function operatorSearch(string $phone){
        $action = OperatorSearch::create()->setPhone($phone);
        return self::create()->request($action);
    }

    public static function deliveryStatus(int $id)
    {
        $action = DeliveryStatus::create()->setId($id);
        return self::create()->request($action);
    }

    public static function balance()
    {
        $action = GetBalance::create();
        return self::create()->request($action);
    }

    public static function send(string $content, array $recipients)
    {
        $action = PushSmsMessage::create()->setContent($content)->setRecipients($recipients);
        return self::create()->request($action);
    }

    /**
     * @param ApiAction $action
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public function request(ApiAction $action)
    {
        try {
            $action->validate();

            $params = $action->getParams();
            $params = $this->prepareParams($params);

            $response = $this
                ->client
                ->request($action->getMethod(), $this->domain . $action->getEndpoint(), $params);

            $response = json_decode((string)$response->getBody(), true);

            if (Arr::get($response, 'meta.code') !== 200) {
                throw new \DomainException(Arr::get($response, 'meta.message'), Arr::get($response, 'meta.status_id'));
            }

            return $response;
        } catch (\DomainException $exception) {
            throw CouldNotSendNotification::pushSMSRespondedWithAnError($exception);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithPushSMS($exception);
        }
    }
}
