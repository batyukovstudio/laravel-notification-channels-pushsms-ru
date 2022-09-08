<?php

namespace NotificationChannels\PushSMS;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use NotificationChannels\PushSMS\ApiActions\Interfaces\ApiAction;
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

    public function __construct(array $config, HttpClient $client)
    {
        $this->token  = Arr::get($config, 'access_token');
        $this->client = $client;
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

    /**
     * @param ApiAction $action
     * @return mixed
     * @throws CouldNotSendNotification
     * @throws GuzzleException
     */
    public function send(ApiAction $action)
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
