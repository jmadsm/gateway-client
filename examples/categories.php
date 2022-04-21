<?php

// Require the composer autoloader
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
    $config['tenant_token']
);

var_dump(
    Category::all(1)->next(), // get all categories
//    Category::since("2022-03-18T13:06:09.147Z")->next(), // get categories changed since the specified datetime
//    Category::get(31)->next() // get a specific category
);
