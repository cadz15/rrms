<?php

namespace App\Services;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use App\Interfaces\NotificationServiceInterface;

class SmsNotificationService implements NotificationServiceInterface
{
    private Client $client;

    public function __construct()
    {
        $basic  = new Basic(config('vonage.api_key'), config('vonage.api_secret'));
        $this->client = new Client($basic);
    }

    public function send($to, $from, $message)
    {
        $response = $this->client->sms()->send(
            new \Vonage\SMS\Message\SMS($to, $from, $message)
        );

        $message = $response->current();

        return $message->getStatus() == 0 ? true : false;
    }
}
