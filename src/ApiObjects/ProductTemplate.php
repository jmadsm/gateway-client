<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class ProductTemplate
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all categories
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null, $sinceorder = null, array $expandoptions = null)
    {
        $endpoint = self::$apiPath . '/producttemplates';
        $payload  = ['page' => $page, 'since' => $since, 'sinceorder' => $sinceorder];

        if ($expandoptions) {
            $payload['expandOptions'] = $expandoptions;
        }

        $result = json_decode(Client::getInstance()->get($endpoint, $payload));

        return new ApiObjectResult($result, __METHOD__, $page, [$since, $sinceorder, $expandoptions]);
    }

    /**
     * Returns specific category
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/producttemplates/' . $id));

        return new ApiObjectResult($result);
    }

    /**
     * Returns categories changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $page = 1, $sinceorder = null, array $expandoptions = null)
    {
        return Template::all($page, $since, $sinceorder, $expandoptions);
    }
}
