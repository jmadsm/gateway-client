<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class ProductTemplate
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all templates
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, array $expandoptions = null)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $endpoint = $apiPath . '/producttemplates';
        $payload  = ['page' => $page];

        if ($expandoptions) {
            $payload['expandOptions'] = $expandoptions;
        }

        $result = Client::getInstance()->get($endpoint, $payload);

        return new ApiObjectResult($result, __METHOD__, $page, [$expandoptions]);
    }

    /**
     * Returns specific template
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = Client::getInstance()->get($apiPath . '/producttemplates/' . $id);

        return new ApiObjectResult($result);
    }
}
