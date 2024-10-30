<?php
include "../../Database/databaseController.php";
function getLastFiveHouses()
{
    return getLastFiveHousesFromDb($GLOBALS['conn']);
}

function getCities()
{
    return getCitiesFromDb($GLOBALS['conn']);
}

function getCityDistrictPairs()
{
    $result = getCityDistrictPairsFromDb($GLOBALS['conn']);
    $pairs = [];
    while ($row = $result->fetch_assoc()) {
        $city = $row['city'];
        $district = $row['district'];

        // city yoksa ekle
        if (!isset($pairs[$city])) {
            $pairs[$city] = [];
        }

        // district cityde yoksa ekle
        if (!in_array($district, $pairs[$city])) {
            $pairs[$city][] = $district;
        }
    }
    return $pairs;
}

function getDistrictNeighborhoodPairs()
{
    $result = getDistrictNeighborhoodPairsFromDb($GLOBALS['conn']);
    $pairs = [];
    while ($row = $result->fetch_assoc()) {
        $district = $row['district'];
        $neighborhood = $row['neighborhood'];
        if (!isset($pairs[$district])) {
            $pairs[$district] = [];
        }
        if (!in_array($neighborhood, $pairs[$district])) {
            $pairs[$district][] = $neighborhood;
        }
    }
    return $pairs;
}