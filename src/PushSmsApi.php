<?php

namespace NotificationChannels\PushSMS;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use NotificationChannels\PushSMS\Exceptions\CouldNotSendNotification;

class PushSmsApi
{
    /** @var HttpClient */
    protected $client;

    /** @var string */
    protected $endpoint;

    /** @var string */
    protected $token;

    public function __construct(array $config)
    {
        $this->token = Arr::get($config, 'token');

        $this->client = new HttpClient([
            'timeout' => 5,
            'connect_timeout' => 5,
        ]);
    }

    /**
     * @param $params
     * @return mixed
     * @throws CouldNotSendNotification
     * @throws GuzzleException
     */
    public function send($params)
    {
        $base = [
            'token'   => $this->token,
        ];

        if (Arr::has($params,'phone')) {
            $this->endpoint = 'https://api.pushsms.ru/api/v1/delivery';
        }
        else {
            $this->endpoint = 'https://api.pushsms.ru/api/v1/bulk_delivery';
        }

        $params = array_merge($base, array_filter($params));

        try {
            $response = $this->client->request('POST', $this->endpoint, ['form_params' => $params]);

            $response = json_decode((string) $response->getBody(), true);

            if (Arr::get($response,'meta.code') !== 200) {
                throw new \DomainException(Arr::get($response,'meta.message'), Arr::get($response,'meta.code'));
            }

            return $response;
        } catch (\DomainException $exception) {
            throw CouldNotSendNotification::pushSMSRespondedWithAnError($exception);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithPushSMS($exception);
        }
    }
}
