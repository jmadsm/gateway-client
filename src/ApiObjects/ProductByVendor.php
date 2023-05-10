<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class ProductByVendor
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all products
     *
     * @param int $page
     * @param $since
     * @param $vendorInfo
     * @param $locations
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function get(string $vendorNo, array $vendorItemNo = [], array $locations = [])
    {
        $apiPath  = Client::getInstance()->getApiPath(self::$apiPath);
        $endpoint = $apiPath . '/productsbyvendor';
        $payload  = ['locations' => $locations, 'vendorNo' => $vendorNo, 'vendorItemNo' => $vendorItemNo];

        $result = json_decode(Client::getInstance()->get($endpoint, $payload));

        return new ApiObjectResult($result, __METHOD__, 1, [$locations, $vendorItemNo]);
    }
}
