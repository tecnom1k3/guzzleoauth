<?php
namespace Acme;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Log\LogSubscriber;

class ClientWrapper
{

    /**
     * Create a Guzzle Client, attaching a logging subscriber to it.
     * This will by default send oauth requests to twitter.
     * @param LogSubscriber $logSubscriber
     * @return Client
     */
    public static function get(LogSubscriber $logSubscriber)
    {
        $client = new Client(['base_url' => 'https://api.twitter.com', 'defaults' => ['auth' => 'oauth']]);
        $client->getEmitter()->attach($logSubscriber);

        return $client;
    }

} 