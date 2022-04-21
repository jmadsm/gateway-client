<?php

// Require the composer autoloader
require_once (__DIR__ . '/../vendor/autoload.php');
require_once (__DIR__ . '/config.php');

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Order;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token']
);

var_dump(
   Order::create([
    "order_number" => "TEST-00000000000000000000000000000000000000000000000000000001",
    "date" => "2021-10-14",
    "payment_method" => "quickpay",
    "shipping_method" => "bring",
    "email" => "john@doe.com",
    "billing_contact" => [
        "firstname" => "John",
        "lastname" => "Doe",
        "email" => "john@doe.com",
        "phone" => "11223344",
        "address" => "john street 1",
        "city" => "Randers",
        "postcode" => "8900",
        "country" => "DK"
    ],
    "lines" => [
        [
            "name" => "Coffee beans",
            "sku" => "0001",
            "price" => "99.95",
            "quantity" => "1"
        ]
    ]
   ]),
);
