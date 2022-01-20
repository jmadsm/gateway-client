<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\Client;

class Contact
{
    /**
     * Returns all contacts
     *
     * @return void
     */
    public static function all()
    {
        return Client::getInstance()->service('contacts')->get();
    }

    /**
     * Returns all web contacts
     *
     * @return void
     */
    public static function web()
    {
        return Client::getInstance()->service('contacts')->get('web');
    }
}
