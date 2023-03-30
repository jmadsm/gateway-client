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
    public static function all(int $page = 1, $since = null, array $locations = [], $sinceorder = null, array $expandoptions = null)
    {
        $endpoint = self::$apiPath . '/products';
        $payload  = ['page' => $page, 'since' => $since, 'locations' => $locations, 'sinceorder' => $sinceorder];

        if ($expandoptions) {
            $endpoint  = self::$apiPath . '/productslimited';
            $payload['expandOptions'] = $expandoptions;
        }

        $result = json_decode(Client::getInstance()->get($endpoint, $payload));
        return new ApiObjectResult($result, __METHOD__, $page, [$since, $locations, $sinceorder, $expandoptions]);
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
    public static function since($since, $page = 1, array $locations = [], $sinceorder = null, array $expandoptions = null)
    {
        return Product::all($page, $since, $locations, $sinceorder, $expandoptions);
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
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/netprice/' . urlencode($debitorNumber) . '/' . urlencode($productNumber) . '/' . urlencode($quantity), ['ordertype' => $ordertype]));

        return new ApiObjectResult($result);
    }
}
