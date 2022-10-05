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
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/shippingaddresses/' . $id));
        return new ApiObjectResult($result);
    }
}
