<?php
include "../../Database/databaseController.php";

function getAllHouses()
{
    return getAllHomesFromDb($GLOBALS['conn']);
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

function getDistrictsByCity($city) { // Database eklenecek
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
    $result = getNeighborhoodsFromDb($conn, $district);
    $neighboor = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $neighboor[] = $row["neighborhood"];
        }
    return $neighboor;
    }    
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

function getFilteredHouses($filters)
{
    global $conn;
    $whereConditions = [];

    // Process each filter and add it to the WHERE conditions
    if (!empty($filters['sale_rent'])) {
        $isSale = ($filters['sale_rent'] === 'sale') ? 1 : 0;
        $whereConditions[] = "isSale = '" . $conn->real_escape_string($isSale) . "'";
    }
    if (!empty($filters['city'])) {
        $whereConditions[] = "city = '" . $conn->real_escape_string($filters['city']) . "'";
    }
    if (!empty($filters['district'])) {
        $whereConditions[] = "district = '" . $conn->real_escape_string($filters['district']) . "'";
    }
    if (!empty($filters['neighborhood'])) {
        $whereConditions[] = "neighborhood = '" . $conn->real_escape_string($filters['neighborhood']) . "'";
    }
    if (!empty($filters['house_type'])) {
        $whereConditions[] = "houseType = '" . $conn->real_escape_string($filters['house_type']) . "'";
    }

    // Handle amenities (array of selected options)
    /*
    if (!empty($filters['amenities']) && is_array($filters['amenities'])) {
        $amenityConditions = [];
        foreach ($filters['amenities'] as $amenity) {
            $amenityConditions[] = "amenities LIKE '%" . $conn->real_escape_string($amenity) . "%'";
        }
        // Join amenities conditions with "AND" if you need all selected amenities to match
        // or with "OR" if you want any of the selected amenities to match
        $whereConditions[] = "(" . implode(" OR ", $amenityConditions) . ")";
    }
    */
    // Handle sorting
    $orderBy = "";
    if (!empty($filters['sort'])) {
        switch ($filters['sort']) {
            case "price_asc":
                $orderBy = "ORDER BY price ASC";
                break;
            case "price_desc":
                $orderBy = "ORDER BY price DESC";
                break;
            case "size_asc":
                $orderBy = "ORDER BY size ASC";
                break;
            case "size_desc":
                $orderBy = "ORDER BY size DESC";
                break;
        }
    }

    // Construct the WHERE clause
    $whereSQL = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

    // Complete SQL query
    $sql = "SELECT * FROM houses $whereSQL $orderBy";
    $result = $conn->query($sql);

    return $result;
}


