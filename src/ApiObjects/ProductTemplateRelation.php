<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;

use JmaDsm\GatewayClient\Client;

class ProductTemplateRelation
{
//    private static string $apiPath = '/product/api/v1';
    private static string $apiPath = '/api';

    /**
     * Returns all product template relations
     *
     * @param int $page
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, array $expandoptions = null)
    {
        $endpoint = self::$apiPath . '/producttemplaterelations';
        $payload  = ['page' => $page];

        if ($expandoptions) {
            $payload['expandOptions'] = $expandoptions;
        }

        $result = json_decode(Client::getInstance()->get($endpoint, $payload));
//die(var_dump($result));
        return new ApiObjectResult($result, __METHOD__, $page, [$expandoptions]);
    }

    /**
     * Returns specific product template relation
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/producttemplates/' . $id));

        return new ApiObjectResult($result);
    }
}
