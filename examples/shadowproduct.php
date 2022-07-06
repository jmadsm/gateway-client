<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\ShadowProduct;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token']
);
//var_dump($config);
$products = ShadowProduct::all(1);
//die(var_dump($products->getCurrentElement()->updated_at));

while ($product = $products->next()) {
    var_dump($product->sku);
}

//var_dump(
//    ShadowProduct::all(1)->next(),
//    ShadowProduct::since('2022-04-18T13:06:09.147Z')->next()
//    ShadowProduct::get('WE18880')->next()
//);
