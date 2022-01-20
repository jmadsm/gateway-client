<?php

// Require the composer autoloader
require_once ('../vendor/autoload.php');

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Category;

// Configure the client singleton, this allow
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance('http://localhost/api', 'YO60SpWdFzYaZFg8HM3QJSk136FicLUa5CCN3Hfn', 'jaDQguLa6yhKmMms2h4T6Tzk6K54JLgB');

var_dump(json_decode(
    Category::all()
));
