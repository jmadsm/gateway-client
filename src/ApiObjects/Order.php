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
        $result  = Client::getInstance()->post($apiPath . '/order', $orderData);

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
        $result  = Client::getInstance()->post($apiPath . '/machineorder', $orderData);

        return new ApiObjectResult($result);
    }

    public static function getSalesOrders($customerId, $orderId)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = Client::getInstance()->get($apiPath . '/sales-orders', ['customer_number' => $customerId, 'order_id' => $orderId]);

        return new ApiObjectResult($result, __METHOD__, 0, [$customerId, $orderId]);
    }

    public static function getSalesOrderExternalId($customerNumber, $orderId)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = Client::getInstance()->get($apiPath . '/sales-orders-by-external-order-id', ['customer_number' => $customerNumber, 'order_id' => $orderId]);

        return new ApiObjectResult($result, __METHOD__, 0, [$customerNumber, $orderId]);
    }

    public static function getInvoice($customerNumber, $documentNumber)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = Client::getInstance()->get($apiPath . '/invoice/customer', ['customer_number' => $customerNumber, 'order_id' => $documentNumber]);

        return new ApiObjectResult($result, __METHOD__, 0, [$customerNumber, $documentNumber]);
    }

    public static function getSalesIntegrationInbox($customerId, $documentNumber)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = Client::getInstance()->get($apiPath . '/sales-integration-inbox', ['customer_number' => $customerId, 'order_id' => $documentNumber]);

        return new ApiObjectResult($result, __METHOD__, 0, [$customerId, $documentNumber]);
    }

    public static function getOrderStatus($orderNumber)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = Client::getInstance()->get($apiPath . '/orders/status/'.$orderNumber);

        return new ApiObjectResult($result, __METHOD__, 0, [$orderNumber]);
    }
}
