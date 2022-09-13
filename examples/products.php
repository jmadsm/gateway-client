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
//var_dump($config);
//$products = Product::all(1, null, ['H', 'STPR']);
//$products = Product::since('2022-04-18T13:06:09.147Z', 1, ['Hx', 'H']);
//die(var_dump($products->getCurrentElement()->updated_at));

//while($product = $products->next()) {
//    var_dump($product->sku, $product->inventory);
//}

var_dump(
//    Product::all(1)->next(),
//    Product::all(1, null, ['H', 'STPR'])->next(),
//    Product::since('2022-04-18T13:06:09.147Z', 1, ['H'])->next()
//    Product::since('2022-04-18T13:06:09.147Z', 1, ['H'], 'desc')->next()
//    Product::get('OR1030', ['H'])->next()
//    Product::netPrice("ABC123", "370", 4)
//    Product::netPrice("20266673", "0 434 250 014", 4, 'web')->getCurrentElement()->ordertype
    Product::netPrice("20266673", "0 434 250 014", 4, 'web')->getCurrentElement()
);

