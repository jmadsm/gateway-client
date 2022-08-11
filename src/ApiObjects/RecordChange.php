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
    public static function all(int $page = 1, $since = null)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/recordchanges', ['page' => $page, 'since' => $since]));

        return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns recordchanges from a specific table
     *
     * @param $tableName
     * @return ApiObjectResult
     */
    public static function tableName($tableName)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/recordchanges/tablename/' . urlencode($tableName)));

        return new ApiObjectResult($result);
    }

    /**
     * Returns recordchanges from a specific table
     *
     * @param $tableId
     * @return ApiObjectResult
     */
    public static function tableId($tableId)
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/recordchanges/tableid/' . $tableId));

        return new ApiObjectResult($result);
    }

    /**
     * Returns recordchanges changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $page = 1)
    {
        return RecordChange::all($page, $since);
    }
}
