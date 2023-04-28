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
    $config['tenant_token'],
    $config['api_path'] ?? null
);
$recordchanges = RecordChange::all(1);
//$recordchanges = RecordChange::tableName(1, 'Nonstock Item', '2021-04-18T13:06:09.147Z');

while($recordchange = $recordchanges->next()) {
    var_dump($recordchange);
}

//var_dump(
//    RecordChange::all(1)->next(),
//    RecordChange::since('2022-04-18T13:06:09.147Z')->next()
//    RecordChange::tableId(7002, 1, '2022-04-18T13:06:09.147Z')->next()
//    RecordChange::tableName('Sales Price', 1, '2022-04-18T13:06:09.147Z')->next()
//);
