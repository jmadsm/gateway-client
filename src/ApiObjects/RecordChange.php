<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class RecordChange
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all recordchanges
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null): ApiObjectResult
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/recordchanges',
            ['page' => $page, 'since' => $since]));

        return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns recordchanges from a specific table
     *
     * @param string $tableName
     * @return ApiObjectResult
     */
    public static function tableName(int $page, string $tableName, $since = null): ApiObjectResult
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = json_decode(Client::getInstance()->get($apiPath . '/recordchanges/tablename/' . urlencode($tableName),
            ['page' => $page, 'since' => $since]));

        return new ApiObjectResult($result, __METHOD__, $page, [$tableName, $since]);
    }

    /**
     * Returns recordchanges from a specific table
     *
     * @param int $tableId
     * @return ApiObjectResult
     */
    public static function tableId(int $page, string $tableId, $since = null): ApiObjectResult
    {
        $apiPath = Client::getInstance()->getApiPath(self::$apiPath);
        $result = json_decode(Client::getInstance()->get($apiPath . '/recordchanges/tableid/' . $tableId,
            ['page' => $page, 'since' => $since]));

        return new ApiObjectResult($result, __METHOD__, $page, [$tableId, $since]);
    }

    /**
     * Returns recordchanges changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $page = 1): ApiObjectResult
    {
        return RecordChange::all($page, $since);
    }
}
