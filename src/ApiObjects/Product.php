<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Product
{
//    private static string $apiPath = '/product/api/v1';
    private static string $apiPath = '/api';

    /**
     * Returns all categories
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/products', ['page' => $page, 'since' => $since]));
        return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns specific category
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/products/' . $id));

        return new ApiObjectResult($result);
    }

    /**
     * Returns categories changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $page = 1)
    {
        return Product::all($page, $since);
    }
}
