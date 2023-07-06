<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Order;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token'],
    $config['api_path'] ?? null
);

$result = Order::getCustomerInvoice('76721300', 'TESTAGCO');

var_dump(
    $result
);

/* $uniqueOrderNumber = date('Y-m-d-H:i:s');
var_dump(
   Order::create([
    "order_number" => "O" . $uniqueOrderNumber,
    "date" => date("Y-m-d"),
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
); */

/*var_dump(
    Order::createMachine(
        [
            "order_number" => "M" . $uniqueOrderNumber,
            "date" => date("Y-m-d"),
            "payment_method" => "BANK",
            "shipping_method" => "CIF",
            "email" => "odm+branchdebitor@jma.dk",
            "type" => "machine",
            "shipping_contact" => [
                "firstname" => "Sven",
                "lastname" => " Svensson",
                "email" => "odm+branchdebitor@jma.dk",
                "phone" => "22558666",
                "address" => "Tegelbruksgatan 3",
                "address_2" => "",
                "city" => "KVÄNUM",
                "postcode" => "535 30",
                "country" => "SE",
                "company" => "Söderberg & Haak Kvänum AB"
            ],
            "billing_contact" => [
                "firstname" => "Sven",
                "lastname" => " Svensson",
                "email" => "odm+branchdebitor@jma.dk",
                "phone" => "22558666",
                "address" => "Tegelbruksgatan 3",
                "address_2" => "",
                "city" => "KVÄNUM",
                "postcode" => "535 30",
                "country" => "SE",
                "company" => "Söderberg & Haak Kvänum AB"
            ],
            "lines" => [
                [
                    "name" => "ZA Super, bas gödningsspridare",
                    "sku" => "AMA117304-3",
                    "price" => "31779.8",
                    "quantity" => "1"
                ],
                [
                    "name" => "Söderberg & Haak Distribution",
                    "price" => "0",
                    "quantity" => "1",
                    "sku" => "FR20"
                ]
            ],
            "line_configurations" => [
                [
                    "id" => "2795",
                    "description" => "ZA Super, bas gödningsspridare",
                    "quantity" => "1"
                ],
                [
                    "id" => "2796",
                    "description" => "Vågsystem för ZA Super",
                    "quantity" => "1"
                ],
                [
                    "id" => "2797",
                    "description" => "Vågsystem för ZA Super",
                    "quantity" => "1"
                ]
            ],
            "customer_comments" => "",
            "order_type" => "SMSK",
            "require_full_delivery" => "true",
            "customer_id" => "387",
            "contact_no" => "SOH-001222"
        ]
    )
);*/
