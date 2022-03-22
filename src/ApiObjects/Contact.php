<?php

namespace JmaDsm\GatewayClient\ApiObjects;

use JmaDsm\GatewayClient\ApiObjectResult;
use JmaDsm\GatewayClient\Client;

class Contact
{
    /**
     * Returns all contacts
     *
     * @return JmaDsm\GatewayClient\ApiObjectResult;
     */
    public static function all(int $page = 1, $since = null)
    {
        $result = json_decode(Client::getInstance()->service('contacts')->get('', ['page' => $page, 'since' => $since]));
        $contacts = $result->data;

        // Iterate through remaining contacts pages
        while ($result->current_page <= $result->last_page) {
            $result = json_decode(Client::getInstance()->service('contacts')->get('', ['page' => ($result->current_page + 1), 'since' => $since]));
            $contacts = array_merge($contacts, $result->data);
        }

        return new ApiObjectResult($contacts);
    }

    /**
     * Returns specific contact
     *
     * @param $id
     * @return string
     */
    public static function get($id)
    {
        $result = json_decode(Client::getInstance()->service('contacts')->get($id));
        return new ApiObjectResult($result->data);
    }

    /**
     * Returns all web contacts
     *
     * @return void
     */
    public static function web($page = 1)
    {
        $result = json_decode(Client::getInstance()->service('webshopcontacts')->get('', ['page' => $page]));
        return new ApiObjectResult($result->data);
    }

    /**
     * Returns contacts changed since $from date. Defaults to page 1
     *
     * @param $since
     * @param int $page
     * @return ApiObjectResult
     */
    public static function since($since, int $page = 1)
    {
        return Contact::all($page, $since);
    }
}
