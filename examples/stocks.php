<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Stock;

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
    //Stock::all(['H', 'B2'], 1207750, true)->getData(),
//   Stock::since("2021-10-05")->next(),
   Stock::get('OR1030', ['H'], true)->next()
);
