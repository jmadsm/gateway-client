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
    public static function all()
    {
        return Client::getInstance()->service('categories')->get();
    }
}
