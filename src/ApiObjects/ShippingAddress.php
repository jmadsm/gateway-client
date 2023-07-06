<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjectResult;

class ShippingAddress
{
    private static string $apiPath = '/contact/api/v1';

    /**
     * @param $id
     *
     *  Takes a string parameter as identifier
     */

    public static function get($id)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = Client::getInstance()->get($apiPath . '/shippingaddresses/' . $id);
        return new ApiObjectResult($result);
    }
}
