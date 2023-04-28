<?php

// Require the composer autoloader
global $config;
require_once (__DIR__ . '/../vendor/autoload.php');
require_once (__DIR__ . '/config.php');

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Category;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token'],
    $config['api_path'] ?? null
);

/*
$categories = Category::all(1);

while($category = $categories->next()) {
    var_dump($category->name);
}
*/

var_dump(
    Category::all(1), // get all categories
//    Category::since("2022-03-18T13:06:09.147Z"), // get categories changed since the specified datetime
//    Category::get(31) // get a specific category
);
