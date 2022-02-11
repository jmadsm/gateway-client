<?php

// Require the composer autoloader
require_once ('../vendor/autoload.php');

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Category;

// Configure the client singleton, this allow
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance('http://localhost/api', '3AIHgY2AK63yBltLImGomMoXSAOk1WOv4pQYv5Uu', 'jaDQguLa6yhKmMms2h4T6Tzk6K54JLgB');


// get all categories
var_dump(json_decode(
    Category::all(3)
));

/*
// get specific category
var_dump(json_decode(
    Category::get(1)
));

// get changed categories since $from dateTime
var_dump(json_decode(
    Category::getDeltaUpdates('2022-01-10T13:46:37.307Z', 2)
));
*/
