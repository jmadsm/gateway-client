<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class ShadowProduct
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all shadow products
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = json_decode(Client::getInstance()->get($apiPath . '/shadowproducts', ['page' => $page, 'since' => $since]));

        return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns specific shadow product
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = json_decode(Client::getInstance()->get($apiPath . '/shadowproducts/' . $id));

        return new ApiObjectResult($result);
    }

    /**
     * Returns shadow products changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $page = 1)
    {
        return ShadowProduct::all($page, $since);
    }
}
