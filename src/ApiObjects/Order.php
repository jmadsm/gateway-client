<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Order
{
//    private static string $apiPath = '/order/api/v1';
    private static string $apiPath = '/api';

    /**
     * Create order
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

    /**
     * Create machine order
     * Only one machine pr. order. Spareparts must be put in an other order.
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function createMachine(array $orderData)
    {
        $result = json_decode(Client::getInstance()->post(self::$apiPath . '/machineorder', $orderData));

        return new ApiObjectResult($result);
    }
}
