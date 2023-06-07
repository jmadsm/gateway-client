<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Order
{
    private static string $apiPath = '/order/api/v1';
    //private static string $apiPath = '/api';

    /**
     * Create order
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function create(array $orderData)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = json_decode(Client::getInstance()->post($apiPath . '/order', $orderData));

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
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = json_decode(Client::getInstance()->post($apiPath . '/machineorder', $orderData));

        return new ApiObjectResult($result);
    }

    public static function getSalesOrders($customerId, $orderId)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = json_decode(Client::getInstance()->get($apiPath . '/sales-orders', ['customer_id' => $customerId, 'order_id' => $orderId]));

        return new ApiObjectResult($result, __METHOD__, 0, [$customerId, $orderId]);
    }

    public static function getSalesOrderExternalId($customerId, $orderId)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = json_decode(Client::getInstance()->get($apiPath . '/sales-orders-by-external-order-id', ['customer_id' => $customerId, 'order_id' => $orderId]));

        return new ApiObjectResult($result, __METHOD__, 0, [$customerId, $orderId]);
    }
}
