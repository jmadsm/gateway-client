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
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = Client::getInstance()->get($apiPath . '/productimages/' . $id);

        return new ApiObjectResult($result);
    }
}
