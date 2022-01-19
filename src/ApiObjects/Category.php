<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\Client;

class Category
{
    public static function all()
    {
        return Client::getInstance()->service('categories')->get();
    }
}
