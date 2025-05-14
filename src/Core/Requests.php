<?php

namespace AymardKouakou\OrangeApiPhp\Core;

use Cake\Http\Client;
use Monolog\Logger;

class Requests
{
    protected static ?Logger $logger = null;

    /**
     * @param array $headers
     * @param string $method Method post|get
     * @param string $url
     * @param array $data
     * @param Logger|null $logger
     * @return array
     * @throws \Exception
     */
    public static function call(
        array  $headers,
        string $method,
        string $url,
        array  $data = [],
        ?Logger $logger = null
    ): array
    {
        $client = new Client();
        $result = $client->$method(
            $url,
            json_encode($data),
            ['headers' => $headers, 'type' => 'json']
        );

        if ($logger !== null) {
            $logger->log(
                (in_array($result->getStatusCode(), [200, 201]) ? Logger::DEBUG : Logger::ERROR),
                json_encode($result->getJson())
            );
        }

        return $result->getJson();
    }
}