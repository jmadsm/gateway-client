<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\ProductTemplateRelation;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token']
);
//die(var_dump($config));
/*
$contacts = Contact::all(1);
$contacts = Contact::since("2021-10-05");

while($contact = $contacts->next()) {
    var_dump($contact->name);
}
*/

var_dump(
    ProductTemplateRelation::all(),
//    ProductTemplateRelation::get("AMA117304-3"),
);
