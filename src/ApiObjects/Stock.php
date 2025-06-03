<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Stock
{
    private static string $apiPath = '/stock/api/v1';

    /**
     * Returns all stocks
     * @param $locations
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all($locations = [], $since = null, bool $showReserved = false)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = Client::getInstance()->get($apiPath . '/stock', ['locations' => $locations, 'from' => $since, 'showReserved' => $showReserved]);

        $statusCode = Client::getInstance()->getStatusCode();
        
        return new ApiObjectResult($result, __METHOD__, statusCode: $statusCode);
    }

    /**
     * Returns specific stock
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get(string $id, array $locations = [], bool $showReserved = false)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = Client::getInstance()->get($apiPath . '/product', ['sku' => $id, 'locations' => $locations, 'showReserved' => $showReserved]);

        $statusCode = Client::getInstance()->getStatusCode();
        
        return new ApiObjectResult($result, statusCode: $statusCode);
    }

    /**
     *
     *
     * @param $since
     * @param int $locations
     * @return ApiObjectResult
     */
    public static function since($since, $locations = [])
    {
        return Stock::all($locations, $since);
    }
}
