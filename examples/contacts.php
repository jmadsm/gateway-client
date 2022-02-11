<?php

// Require the composer autoloader
require_once ('../vendor/autoload.php');

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Contact;

// Configure the client singleton, this allow
// all the ApiObjects to perform requests using
// this configuration
Client::getInstance('http://localhost/api', 'HzWAFCtkv2VDu1CSaQYfk7dOTVzoOwbYXdRRy2Zu', 'jaDQguLa6yhKmMms2h4T6Tzk6K54JLgB');

// Get all Contacts
var_dump(json_decode(
    Contact::all(2)
));


/*

// get changed contacts since $from dateTime
var_dump(json_decode(
    Contact::getDeltaUpdates('2022-01-10T13:46:37.307Z', 2)
));

// get info about the contacts service
var_dump(json_decode(
    Contact::getInfo(true)
));

*/
