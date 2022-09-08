<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Product
{
    private static string $apiPath = '/product/api/v1';

    /**
     * Returns all categories
     *
     * @param int $page
     * @param $since
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null, array $locations = [])
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/products', ['page' => $page, 'since' => $since, 'locations' => $locations]));

        return new ApiObjectResult($result, __METHOD__, $page, [$since]);
    }

    /**
     * Returns specific category
     *
     * @param $id
     * @return ApiObjectResult
     */
    public static function get($id, array $locations = [])
    {
        $result = json_decode(Client::getInstance()->get(self::$apiPath . '/products/' . $id, ['locations' => $locations]));

        return new ApiObjectResult($result);
    }

    /**
     * Returns categories changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, $page = 1, array $locations = [])
    {
        return Product::all($page, $since, $locations);
    }

    /**
     * Returns net price on orderline from DSM calculation
     *
     * @param string $productNo
     * @param string $debitorNo
     * @param int $qty
     * @return decimal calculated NET price on order line
     */
    public static function netPriceOrderLine($productNo, $debitorNo, $qty)
    {
        $result = json_decode('{
            "current_page": 1,
            "data": [
                {
                    "line_price": 1295.20,
                    "stub": true
                }
            ],
            "first_page_url": "/?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "/?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "/?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "/",
            "per_page": "500",
            "prev_page_url": null,
            "to": 1,
            "total": null
        }');

        return new ApiObjectResult($result);
    }
}
