<?php
include '../../Database/databaseController.php';

header('Content-Type: application/json');

if (isset($_GET['district'])) {
    $district = $_GET['district'];
    echo getNeighborhoodsJson($district);
} else {
    echo json_encode([]);
}

function getNeighborhoods($district){
    return takeAllNeighborhoods($GLOBALS['conn'],$district );
}

function getNeighborhoodsJson($district) {
    $neighborhoods = getNeighborhoods($district);
    $neighborhoodsArray = [];

    foreach($neighborhoods as $neighborhood){
        $neighborhoodsArray[] = $neighborhood['mahalle_adi'];
    }

    return json_encode($neighborhoodsArray);
}