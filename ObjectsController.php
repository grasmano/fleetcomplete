<?php

include ('DateHelper.php');

$json = json_decode(file_get_contents("php://input"), true);

$dateTimeNow = date('Y-m-d h:i:s');

$objects = [];
foreach ($json as $item) {
    $object['objectId'] = $item['objectId'];
    $object['timestamp'] = $item['timestamp'];
    $object['lastUpdate'] = DateHelper::dateDiff($item['timestamp'], $dateTimeNow);
    $object['latitude'] = $item['latitude'];
    $object['longitude'] = $item['longitude'];
    $object['speed'] = $item['speed'] ? $item['speed'] : 0;
    $object['lastEngineOnTime'] = $item['lastEngineOnTime'];
    $object['objectName'] = $item['objectName'];
    $object['driverName'] = $item['driverName'];
    $objects[] = $object;
}

echo json_encode($objects);

?>