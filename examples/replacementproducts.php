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
    $config['tenant_token']
);
//var_dump($config);
$replacementproducts = ReplacementProduct::all(1);
//die(var_dump($replacementproducts->getCurrentElement()->updated_at));

while($replacementproduct = $replacementproducts->next()) {
    var_dump($replacementproduct->sku);
}

//var_dump(
//    Product::all(1)->next(),
//    Product::since('2022-04-18T13:06:09.147Z')->next()
//    Product::get('WE18880')->next()
//);
