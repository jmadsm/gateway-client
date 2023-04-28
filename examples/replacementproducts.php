<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\ReplacementProduct;
// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token'],
    $config['api_path'] ?? null
);

var_dump(
    ReplacementProduct::all(1)->next(),
//    ReplacementProduct::since('2022-04-18T13:06:09.147Z')->next()
//    ReplacementProduct::get('GR1125170369')->next()
);
