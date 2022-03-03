<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Category
{
    /**
     * Returns all categories
     *
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1)
    {
        // Get first category page
        $result = json_decode(Client::getInstance()->service('categories')->get("?page=1"));
        $categories = $result->data;

        // Iterate through remaining category pages
        while ($result->current_page <= $result->last_page) {
            $result = json_decode(Client::getInstance()->service('categories')->get("?page=" . $result->current_page + 1));
            $categories = array_merge($categories, $result->data);
        }

        return new ApiObjectResult($categories);
    }

    /**
     * Returns specific category
     *
     * @param $id
     * @return string
     */
    public static function get($id)
    {
        return Client::getInstance()->service('categories')->get($id);
    }

    /**
     * Returns categories changed since $from date. Defaults to page 1
     *
     * @param $from
     * @param int $page
     * @return string
     */
    public static function getDeltaUpdates($from, $page = 1)
    {
        return Client::getInstance()->service('categories')->get('delta/' . $from . '?page=' . $page);
    }
}
