<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Customer
{
    private static string $apiPath = '/contact/api/v1';

    /**
     * Returns a specific customer
     * This object is sometimes referred to as a Account or Debitor.
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id)
    {
        $apiPath  = Client::getInstance()->getApiPath(self::$apiPath);

        $endpoint = $apiPath . '/customers/' . $id;
        $result = Client::getInstance()->get($endpoint);

        $statusCode = Client::getInstance()->getStatusCode();
        
        return new ApiObjectResult($result, __METHOD__, 1, [], statusCode: $statusCode);
    }

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
        $payload  = ['customer_number' => $dsmCustomerNumber];

        $result = Client::getInstance()->get($endpoint, $payload);

        $statusCode = Client::getInstance()->getStatusCode();
        
        return new ApiObjectResult($result, __METHOD__, 1, [$dsmCustomerNumber], statusCode: $statusCode);
    }
}
