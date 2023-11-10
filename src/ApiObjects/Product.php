<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Product
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all products
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null, array $locations = [], $sinceorder = null, array $expandoptions = null)
    {
        $apiPath  = Client::getInstance()->getApiPath(self::$apiPath);
        $endpoint = $apiPath . '/products';
        $payload  = ['page' => $page, 'since' => $since, 'locations' => $locations, 'sinceorder' => $sinceorder];

        if ($expandoptions) {
            $endpoint                 = $apiPath . '/productslimited';
            $payload['expandOptions'] = $expandoptions;
        }

        $result = Client::getInstance()->get($endpoint, $payload);

        return new ApiObjectResult($result, __METHOD__, $page, [$since, $locations, $sinceorder, $expandoptions]);
    }

    /**
     * Returns specific product
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id, array $locations = [])
    {
        $result = Client::getInstance()->get(Client::getInstance()->getApiPath(self::$apiPath) . '/products/' . $id, ['locations' => $locations]);

        return new ApiObjectResult($result);
    }

    /**
     * Returns products changed since $from date. Defaults to page 1
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
        $payload = ['customerNo' => $debitorNumber, 'quantity' => (int) $quantity, 'itemNumber' => $productNumber, 'ordertype' => $ordertype];
        $result  = Client::getInstance()->get(Client::getInstance()->getApiPath(self::$apiPath) . '/netprice/calculate', (array) $payload);

        return new ApiObjectResult($result, __METHOD__, 1, [$debitorNumber, $quantity, $productNumber]);
    }

    public static function getVariant($id): ApiObjectResult
    {
        $result = Client::getInstance()->get(Client::getInstance()->getApiPath(self::$apiPath) . '/variants/' . $id, []);

        return new ApiObjectResult($result);
    }
}
