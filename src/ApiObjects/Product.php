<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Product
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all categories
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null, array $locations = [], $sinceorder = null)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/products', ['page' => $page, 'since' => $since, 'locations' => $locations, 'sinceorder' => $sinceorder]));

        return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns specific category
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id, array $locations = [])
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/products/' . $id, ['locations' => $locations]));

        return new ApiObjectResult($result);
    }

    /**
     * Returns categories changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $page = 1, array $locations = [], $sinceorder = null)
    {
        return Product::all($page, $since, $locations, $sinceorder);
    }

    /**
     * Returns net price from DSM calculation
     *
     * @param string $productNumber
     * @param string $debitorNumber
     * @param int $quantity
     * @return ApiObjectResult
     */
    public static function netPrice($debitorNumber, $productNumber, $quantity, $ordertype = null)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . "/netprice/" . urlencode($debitorNumber) . "/" . urlencode($productNumber) . "/" . urlencode($quantity), ['ordertype' => $ordertype]));

        return new ApiObjectResult($result);
    }
}
