<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\Client;

class Category
{
    /**
     * Returns all categories
     *
     * @return string
     */
    public static function all($page = 1)
    {
        return Client::getInstance()->service('categories')->get('?page=' . $page);
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
