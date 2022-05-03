<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Product;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token']
);

var_dump(
//    Product::all(1)->next(),
//    Product::since('2022-03-18T13:06:09.147Z')->next()
    Product::get('aaa0dd99-4ce9-4ccc-833d-7a5f5d5c61aa')->next()
);
