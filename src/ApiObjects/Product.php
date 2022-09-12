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
    public static function all(int $page = 1, $since = null, array $locations = [])
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/products', ['page' => $page, 'since' => $since, 'locations' => $locations]));

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
    public static function since($since, $page = 1, array $locations = [])
    {
        return Product::all($page, $since, $locations);
    }

    /**
     * Returns net price from DSM calculation
     *
     * @param string $productNumber
     * @param string $debitorNumber
     * @param int $quantity
     * @return ApiObjectResult
     */
    public static function netPrice($productNumber, $debitorNumber, $quantity)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . "/netprice/" . urlencode($productNumber) . "/" . urlencode($debitorNumber) . "/" . urlencode($quantity)));

//die(var_dump($result));
        return new ApiObjectResult($result);
    }
}
