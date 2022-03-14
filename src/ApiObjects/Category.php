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
    public static function all(int $page = 1, $since = null)
    {
        // Get first category page
        $url = $since
            ? '?since=' . $since . '&page='
            : '?page=';

        $result = json_decode(Client::getInstance()->service('categories')->get($url . $page));
        $categories = $result->data;

        // Iterate through remaining category pages
        while ($result->current_page <= $result->last_page) {
            $result = json_decode(Client::getInstance()->service('categories')->get( $url . $result->current_page + 1));
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
     * @param $since
     * @param int $page
     * @return string
     */
    public static function since($since, $page = 1)
    {
        return Category::all($page, $since);
    }
}
