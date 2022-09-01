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
//$recordchanges = RecordChange::tableId(1, "01265201", '2021-04-18T13:06:09.147Z');
//$recordchanges = RecordChange::tableName(1, 'Nonstock Item', '2021-04-18T13:06:09.147Z');

while($recordchange = $recordchanges->next()) {
    var_dump($recordchange);
}

//var_dump(
//    RecordChange::all(1)->next(),
//    RecordChange::since('2022-04-18T13:06:09.147Z')->next()
//    RecordChange::get('OR1030')->next()
//    RecordChange::tableId(2222222, 1, '2022-04-18T13:06:09.147Z')->next()
//    RecordChange::tableName('Sales Price', 1, '2022-04-18T13:06:09.147Z')->next()
//    RecordChange::tableId('OR1030')->next()
//);
