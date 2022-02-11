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
    public static function all($page = 1)
    {
        // todo add support for pagination
        return Client::getInstance()->service('contacts')->get('?page=' . $page);
    }

    /**
     * Returns specific contact
     *
     * @param $id
     * @return string
     */
    public static function get($id)
    {
        return Client::getInstance()->service('contacts')->get($id);
    }

    /**
     * Returns all web contacts
     *
     * @return void
     */
    public static function web($page = 1)
    {
        return Client::getInstance()->service('webshopcontacts')->get('?page=' . $page);
    }

    /**
     * Returns live information about the Contact service.
     * $exportToWebshop sets whether you want all contacts
     *
     * @param false $exportToWebshop
     * @return string
     */
    public static function getInfo($exportToWebshop = false)
    {
        $exportToWebshop = boolval($exportToWebshop) ? 'true' : 'false';
        return Client::getInstance()->service('contacts')->get('/info', ["exportToWebshop" => $exportToWebshop]);
    }

    /**
     * Returns contacts changed since $from date. Defaults to page 1
     *
     * @param $from
     * @param int $page
     * @return string
     */
    public static function getDeltaUpdates($from, $page = 1)
    {
        return Client::getInstance()->service('contacts')->get('delta/' . $from . '?page=' . $page);
    }
}
