<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Order
{
    /**
     * Returns all categories
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function create(array $orderData)
    {
        $result = json_decode(Client::getInstance()->service('order')->post('', $orderData));

        return new ApiObjectResult($result);
    }
}
