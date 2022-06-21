<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Stock
{
    private static string $apiPath = '/stock/api/v1';

    /**
     * Returns all categories
     *
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all($locations = [], $since = null)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/stock', ['locations' => $locations, 'from' => $since]));

        //return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns specific category
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/sku=' . $id));

        //return new ApiObjectResult($result);
    }

    /**
     * Returns categories changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $locations = [])
    {
        return Stock::all($locations, $since);
    }
}
