<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\ProductNote;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token']
);

$shippingaddresses      = ProductNote::get('0 434 250 014');
//$shippingaddressesSince = ShippingAddress::since('2021-10-05');

var_dump($shippingaddresses);

/* var_dump(
//   Contact::all()->next(),
//   Contact::since("2021-10-05")->next(),
   Contact::get("E005375")->next()
); */
