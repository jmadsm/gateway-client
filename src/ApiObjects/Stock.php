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
        $result = json_decode(Client::getInstance()->get($apiPath . '/stock', ['locations' => $locations, 'from' => $since, 'showReserved' => $showReserved]));

        return new ApiObjectResult($result, __METHOD__);
    }

    /**
     * Returns specific stock
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = json_decode(Client::getInstance()->get($apiPath . '/product', ['sku' => $id]));

        return new ApiObjectResult($result);
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
