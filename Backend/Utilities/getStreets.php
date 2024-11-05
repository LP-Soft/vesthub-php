<?php
include '../../Database/databaseController.php';

header('Content-Type: application/json');

if (isset($_GET['neighborhood'])) {
    $neighborhood = $_GET['neighborhood'];
    echo getStreetsJson($neighborhood);
} else {
    echo json_encode([]);
}

function getStreets($neighborhood) {
    return takeAllStreets($GLOBALS['conn'], $neighborhood);
}

function getStreetsJson($neighborhood) {
    $streets = getStreets($neighborhood);
    $neighborhoodsArray = [];

    foreach($streets as $street){
        $streetsArray[] = $street['sokak_adi'];
    }

    return json_encode($streetsArray);
}