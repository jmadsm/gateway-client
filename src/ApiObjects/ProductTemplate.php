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
    public static function all(int $page = 1, array $expandoptions = null, int $perPage = 25, string $since = null, bool $templateRules = null)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $endpoint = $apiPath . '/producttemplates';
        $payload  = ['page' => $page, 'perPage' => $perPage, 'since' => $since, 'template_rules' => $templateRules];

        if ($expandoptions) {
            $payload['expandOptions'] = $expandoptions;
        }

        $result = Client::getInstance()->get($endpoint, $payload);

        $statusCode = Client::getInstance()->getStatusCode();

        return new ApiObjectResult($result, __METHOD__, $page, [$expandoptions], statusCode: $statusCode);
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
        
        $statusCode = Client::getInstance()->getStatusCode();

        return new ApiObjectResult($result, statusCode: $statusCode);
    }

    /**
     * Returns products changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, int $page = 1, array $expandoptions = null, $perPage = 25)
    {
        return ProductTemplate::all($page, $expandoptions, $perPage, $since, );
    }
}
