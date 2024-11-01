<?php
include "../../Database/databaseController.php";

function getAllHouses()
{
    return getAllHomes($GLOBALS['conn']);
}

function getCity() {
    $result = getCitiesFromDb($GLOBALS['conn']);
    $cities = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cities[] = $row['city']; // Assuming `city` is the correct column name
        }
    }
    return $cities;
}

function getDistrictsByCity($city) {
    global $conn;
    $stmt = $conn->prepare("SELECT DISTINCT district FROM houses WHERE city = ?");
    $stmt->bind_param("s", $city);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $districts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $districts[] = $row['district'];
        }
    }
    return $districts;
}

function getNeighboorhoodByDistrict($district) {
    global $conn;
    $stmt = $conn->prepare("SELECT DISTINCT neighborhood FROM houses WHERE district = ?");
    $stmt->bind_param("s", $district);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $neighboor = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $neighboor[] = $row["neighborhood"];
        }
    return $neighboor;
    }    
}

