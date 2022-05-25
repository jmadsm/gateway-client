<?php

// Require the composer autoloader
require_once (__DIR__ . '/../vendor/autoload.php');
require_once (__DIR__ . '/config.php');

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Contact;

// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token']
);

/*
$contacts = Contact::all(1);
$contacts = Contact::since("2021-10-05");

while($contact = $contacts->next()) {
    var_dump($contact->name);
}
*/

var_dump(
//   Contact::all()->next(),
//   Contact::since("2021-10-05")->next(),
   Contact::get("E005375")->next()
);
