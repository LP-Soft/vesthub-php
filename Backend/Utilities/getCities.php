<?php
include '../../Database/databaseController.php';

header('Content-Type: application/json');

echo getCitiesJson();

function getCities()
{
    return takeAllCitiesFromDb($GLOBALS['conn']);
}

function getCitiesJson() {
    $cities = getCities();
    $citiesArray = [];

    foreach($cities as $city){
        $citiesArray[] = $city['il_adi'];
    }

    return json_encode($citiesArray);
}

?>