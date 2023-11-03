<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjectResult;

class Property
{
    /**
     * @var string
     */
    private static string $apiPath = '/product/api/v1';

    /**
     * @param int $page
     *
     * @return ApiObjectResult
     */
    public static function all(int $page = 1): ApiObjectResult
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result  = Client::getInstance()->get($apiPath . '/properties');

        return new ApiObjectResult($result, __METHOD__, $page);
    }
}
