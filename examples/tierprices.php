<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Tierprice;
// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration

Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token'],
    $config['api_path'] ?? null
);
$tierprices = Tierprice::all(1);

while($tierprice = $tierprices->next()) {
    var_dump($tierprice);
}

var_dump(
//    Tierprice::all(1)->next(),
//    Tierprice::since('2022-04-18T13:06:09.147Z')->next()
//    Tierprice::get('OR1030')->next()
);
