<?php
include '../../Database/databaseController.php';

header('Content-Type: application/json');

if (isset($_GET['neighborhood']) && isset($_GET['district']) && isset($_GET['city'])) {
    $neighborhood = $_GET['neighborhood'];
    $district = $_GET['district'];
    $city = $_GET['city'];

    error_log("Neighborhood: $neighborhood, District: $district, City: $city");
    echo getStreetsJson($neighborhood, $district, $city);
} else {
    echo json_encode([]);
}

function getStreets($neighborhood, $district, $city) {
    return takeAllStreetsFromDb($GLOBALS['conn'], $neighborhood, $district, $city);
}

function getStreetsJson($neighborhood, $district, $city) {
    $streets = getStreets($neighborhood, $district, $city);
    $streetsArray = [];

    foreach($streets as $street){
        $streetsArray[] = $street['sokak_adi'];
    }
    //echo "final: ".json_encode($streetsArray);
    return json_encode($streetsArray);
}