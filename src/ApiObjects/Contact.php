<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Contact
{
    private static string $apiPath = '/contact/api/v1';

    /**
     * Returns all contacts
     *
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = json_decode(Client::getInstance()->get($apiPath . '/contacts', ['page' => $page, 'since' => $since]));
        return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns specific contact
     *
     * @param $id
     * @return string
     */
    public static function get($id)
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = json_decode(Client::getInstance()->get($apiPath . '/contacts/' . $id));
        return new ApiObjectResult($result);
    }

    /**
     * Returns contacts changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, int $page = 1)
    {
        return Contact::all($page, $since);
    }
}
