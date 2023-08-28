<?php

// Require the composer autoloader
global $config;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Customer;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
 Client::getInstance(
     $config['base_url'],
     $config['access_token'],
     $config['tenant_token'],
     $config['api_path'] ?? null
 );
//die(var_dump($config));
var_dump(
//    Customer::getCreditLimit(76721300),
//    Customer::getCreditLimit("76721300"),
    Customer::get("76721300"),
);
