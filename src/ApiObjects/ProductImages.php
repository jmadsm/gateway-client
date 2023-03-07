<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjectResult;

class ProductImages
{
    private static string $apiPath = '/product/api/v1';

    /**
     * @param $id
     *
     *  Takes a string parameter as identifier
     */
    public static function get($id)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/productimages/' . $id));

        return new ApiObjectResult($result);
    }
}
