<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class ProductLimited
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all categories
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null, array $locations = [], $sinceorder = null, array $expandoptions = [])
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/productslimited', ['page' => $page, 'since' => $since, 'locations' => $locations, 'sinceorder' => $sinceorder, 'expandoptions' => $expandoptions]));

        return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns categories changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $page = 1, array $locations = [], $sinceorder = null, array $expandoptions = [])
    {
        return Product::all($page, $since, $locations, $sinceorder, $expandoptions);
    }
}
