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
    public static function all(int $page = 1, $since = null, $perPage = 1000)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = Client::getInstance()->get($apiPath . '/shadowproducts', ['page' => $page, 'since' => $since, 'per_page' => $perPage]);

        $statusCode = Client::getInstance()->getStatusCode();
        
        return new ApiObjectResult($result, __METHOD__, $page, [$since], statusCode: $statusCode);
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
        $result = Client::getInstance()->get($apiPath . '/shadowproducts/' . $id);

        $statusCode = Client::getInstance()->getStatusCode();
        
        return new ApiObjectResult($result, statusCode: $statusCode);
    }

    /**
     * Returns specific shadow products, based on multiple id's
     *
     * @param  mixed $ids
     * @param  mixed $page
     * @param  mixed $perPage
     * @return ApiObjectResult
     */
    public static function bulk(array $ids, ?int $page = 1, ?int $perPage = 300)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = Client::getInstance()->get($apiPath . '/shadowproducts/bulk', ['page' => $page, 'per_page' => $perPage, 'id' => $ids]);

        $statusCode = Client::getInstance()->getStatusCode();
        
        return new ApiObjectResult($result, __METHOD__, $page, [], statusCode: $statusCode);
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
