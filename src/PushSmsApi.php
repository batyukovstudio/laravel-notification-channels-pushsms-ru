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

        $this->token = $config['token'];
        $this->client = new HttpClient([
            'timeout' => $config('timeout'),
            'connect_timeout' => $config('connect_timeout'),
        ]);
    }

    /**
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public static function balance()
    {
        $action = GetBalance::create();
        $response = (new self())->request($action);
        return $response;
    }

    /**
     * @param int $deliveryId
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public static function deliveryStatus(int $deliveryId)
    {
        $action = DeliveryStatus::create()->setId($deliveryId);
        $response = (new self())->request($action);
        return $response;
    }

    /**
     * @param string $phone
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public static function operatorSearch(string $phone)
    {
        $action = OperatorSearch::create()->setPhone($phone);
        $response = (new self())->request($action);
        return $response;
    }

    /**
     * @param string $content
     * @param array $recipients
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public static function pushSms(string $content, array $recipients)
    {
        $action = PushSmsMessage::create()
            ->setContent($content)
            ->setRecipients($recipients);
        $response = (new self())->request($action);
        return $response;
    }

    /**
     * @param $params
     * @return mixed
     * @throws CouldNotSendNotification
     * @throws GuzzleException
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
                throw new \DomainException(Arr::get($response, 'meta.message'), Arr::get($response, 'meta.code'));
            }

            return $response;
        } catch (\DomainException $exception) {
            throw CouldNotSendNotification::pushSMSRespondedWithAnError($exception);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithPushSMS($exception);
        }
    }

    /**
     * @param array $params
     * @return array
     */
    protected function prepareParams(array $params)
    {
        if (!isset($params['header'])) {
            $params['header'] = [];
        }
        $params['header']['Authorization'] = 'Bearer ' . $this->token;

        return $params;
    }
}
