<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Order
{
    private static string $apiPath = '/order/api/v1';

    /**
     * Returns all categories
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function create(array $orderData)
    {
        $result = json_decode(Client::getInstance()->post(self::$apiPath . '/order', $orderData));

        return new ApiObjectResult($result);
    }
}
