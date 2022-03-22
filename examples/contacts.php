<?php

// Require the composer autoloader
require_once (__DIR__ . '/../vendor/autoload.php');
require_once (__DIR__ . '/config.php');

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Contact;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
$config = getConfig('contacts');

Client::getInstance(
    $config['endpoint'],
    $config['access_token'],
    $config['tenant_token']
);

var_dump(
    Contact::all()->next(),
//    Contact::since("2023-10-05")->next(),
//    Contact::web()->next(),
//    Contact::get("E000001")->next()
);
