<?php

namespace TwoBitsIn\Fast2sms;

use DomainException;
use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use TwoBitsIn\Fast2sms\Exceptions\CouldNotSendNotification;

class Fast2smsClient
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var string
     */
    protected $token;

    public function __construct(HttpClient $httpClient = null)
    {
        $this->client = $httpClient;
        $this->endpoint = env('FAST2SMS_ENDPOINT');
        $this->route = env('FAST2SMS_ROUTE');
        $this->flash = env('FAST2SMS_FLASH');
        $this->sendor_id = env('FAST2SMS_SENDOR_ID');
        $this->auth_token = env('FAST2SMS_AUTH_TOKEN');
    }

    /**
     * Send text message.
     *
     *
     * @param array $message
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws CouldNotSendNotification
     */
    public function send($message = "", $variables_values_arr = [], $to = [])
    {
        if ($this->endpoint == "") {
            throw CouldNotSendNotification::envNotset();
        }
        if ($this->route == "") {
            throw CouldNotSendNotification::envNotset();
        }
        if ($this->flash == "") {
            throw CouldNotSendNotification::envNotset();
        }
        if ($this->sendor_id == "") {
            throw CouldNotSendNotification::envNotset();
        }
        if ($this->auth_token == "") {
            throw CouldNotSendNotification::envNotset();
        }
        try {
            $variables_values = implode('|', $variables_values_arr);
            $numbers = implode(',', $to);

            $params = [
                'message' => $message,
                'variables_values' => $variables_values,
                'numbers' => $numbers
            ];
            $params = array_merge($params, $this->params);
            $res =  $this->client->request(
                'POST',
                $this->endpoint,
                [
                    'headers' => [
                        "Content-Type" => "application/json",
                        "authorization" => $this->auth_token
                    ],
                    'body' => $params
                ]
            );
            $response = json_decode((string) $res->getBody(), true);
            if (isset($response['error'])) {
                throw new DomainException($response['error'], $response['error_code']);
            }

            return $response;
        } catch (ClientException $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e);
        } catch (Exception $e) {
            throw CouldNotSendNotification::couldNotCommunicateWithFast2sms($e);
        }
    }
}
