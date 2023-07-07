<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Customer
{
    private static string $apiPath = '/contact/api/v1';

    /**
     * getCreditLimit
     *
     * @param  mixed $dsmCustomerNumber
     * @return void
     */
    public static function getCreditLimit($dsmCustomerNumber)
    {
        $apiPath  = Client::getInstance()->getApiPath(self::$apiPath);
        $endpoint = $apiPath . '/creditlimit';
        $payload  = ['customerNumber' => $dsmCustomerNumber];

        $result = Client::getInstance()->get($endpoint, $payload);

        return new ApiObjectResult($result, __METHOD__, 1, [$dsmCustomerNumber]);
    }
}
