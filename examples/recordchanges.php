<?php

// Require the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\RecordChange;
// Configure the client singleton, this allows
// all the ApiObjects to perform requests using
// this configuration

Client::getInstance(
    $config['base_url'],
    $config['access_token'],
    $config['tenant_token']
);
$recordchanges = RecordChange::all(1);

while($recordchange = $recordchanges->next()) {
    var_dump($recordchange);
}

//var_dump(
//    RecordChange::all(1)->next(),
//    RecordChange::since('2022-04-18T13:06:09.147Z')->next()
//    RecordChange::get('OR1030')->next()
//    RecordChange::tableId(2222222)->next()
//    RecordChange::tableName('Sales Price')->next()
//    RecordChange::tableId('OR1030')->next()
//);
