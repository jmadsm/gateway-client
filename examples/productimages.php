<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\ProductImages;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token']
);

// Example
// Prerequisite:
// - There is a product named $productId
// - The product has at least one image
$productId = "OR1010";
$imageElement = ProductImages::get($productId)->next()->images[0];
$imageString = base64_decode($imageElement->image_base64);
if(file_put_contents($imageElement->filename, $imageString)) {
    echo "Successfully created the image: " . $imageElement->filename . PHP_EOL;
}
