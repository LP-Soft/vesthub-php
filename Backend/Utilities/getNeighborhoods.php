<?php
include '../../Database/databaseController.php';

header('Content-Type: application/json');

if (isset($_GET['district']) && isset($_GET['city'])) {
    $district = $_GET['district'];
    $city = $_GET['city'];
    echo getNeighborhoodsJson($district, $city);
} else {
    echo json_encode([]);
}

function getNeighborhoods($district, $city){
    return takeAllNeighborhoodsFromDb($GLOBALS['conn'], $district, $city);
}

function getNeighborhoodsJson($district, $city) {
    $neighborhoods = getNeighborhoods($district, $city);
    $neighborhoodsArray = [];

    foreach($neighborhoods as $neighborhood){
        $neighborhoodsArray[] = $neighborhood['mahalle_adi'];
    }

    return json_encode($neighborhoodsArray);
}