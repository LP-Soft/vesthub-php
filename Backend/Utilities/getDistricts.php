<?php
include '../../Database/databaseController.php';

header('Content-Type: application/json');

if (isset($_GET['city'])) {
    $city = $_GET['city'];
    echo getDistrictsJson($city);
} else {
    echo json_encode([]);
}

function getDistricts($city){
    return takeAllDistrictsFromDb($GLOBALS['conn'],$city );
}

function getDistrictsJson($city) {
    $districts = getDistricts($city);
    $districtArray = [];

    foreach($districts as $district){
        $districtArray[] = $district['ilce_adi'];
    }

    return json_encode($districtArray);
}


?>