<?php
require_once "connect.php";
// databaseController.php
if (!defined('DB_LOADED')) {
    define('DB_LOADED', true);

    function getLastFiveHousesFromDb($conn){
        $sql = "SELECT * FROM houses ORDER BY houseID DESC LIMIT 5";
        return $conn->query($sql);
    }

    function getCitiesFromDb($conn){
        $sql = "SELECT DISTINCT city FROM houses";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }

    function getDistrictsFromDb($conn, $city){
        $sql = "SELECT DISTINCT district FROM houses WHERE city = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $city);
        $stmt->execute();
        return $stmt->get_result();
    }

    function getCityDistrictPairsFromDb($conn){
        $sql = "SELECT city, district FROM houses";
        return $conn->query($sql);
    }

    function getDistrictNeighborhoodPairsFromDb($conn){
        $sql = "SELECT district, neighborhood FROM houses";
        return $conn->query($sql);
    }

    function getNeighborhoodsFromDb($conn, $city){
        $sql = "SELECT DISTINCT neighborhood FROM houses WHERE district = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $city);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function getAllHomes($conn) {
        $sql = "SELECT * FROM houses";
        return $conn->query($sql);
    }

    function getHomeById($conn, $id) {
        $sql = "SELECT * FROM homes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    function getHomesByType($conn, $type) {
        $sql = "SELECT * FROM houses WHERE type = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $type);
        $stmt->execute();
        return $stmt->get_result();
    }

    function get_pendingHouses($conn) {
        $sql = "SELECT * FROM houses WHERE status = 'pending'";
        return $conn->query($sql);
    }

    function changeStatus_toApprove($conn, $houseInfoID) {
        $sql = "UPDATE houses SET status = 'approved' WHERE houseID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $houseInfoID);
        $stmt->execute();
    }

    function changeStatus_toCancel($conn, $houseInfoID) {
        $sql = "UPDATE houses SET status = 'cancelled' WHERE houseID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $houseInfoID);
        $stmt->execute();
    }

    function createHouseListingToDb($houseInfo, $conn) {
        // Prepare the SQL statement with correct syntax
        $sql = "INSERT INTO houses (
        ownerID, title, description, numOfRooms, numOfBathroom, numOfBedroom, price, city, district, neighborhood, street, 
        floor, totalFloor, area, lat, lng, isSale, 
        fiberInternet, airConditioner, floorHeating, fireplace, terrace, satellite, parquet, steelDoor, furnished, insulation, status, houseType
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        // Define additional parameters
        $ownerID = 1; // or retrieve this dynamically
        $lat = 40.7128; // example latitude
        $lng = -74.0060; // example longitude
        $numOfBathroom = 1;
        $numOfBedroom = 1;

        if (!$stmt->bind_param(
            'isssiiissssiiiddiiiiiiiiiiiss', // Data types: i for int, s for string, d for double
            $ownerID,
            $houseInfo->title,
            $houseInfo->description,
            $houseInfo->numOfRooms,
            $numOfBathroom,
            $numOfBedroom,
            $houseInfo->price,
            $houseInfo->city,
            $houseInfo->district,
            $houseInfo->neighborhood,
            $houseInfo->street,
            $houseInfo->floor,
            $houseInfo->totalFloor,
            $houseInfo->area,
            $lat,
            $lng,
            $houseInfo->isSale,
            $houseInfo->fiberInternet,
            $houseInfo->airConditioner,
            $houseInfo->floorHeating,
            $houseInfo->fireplace,
            $houseInfo->terrace,
            $houseInfo->satellite,
            $houseInfo->parquet,
            $houseInfo->steelDoor,
            $houseInfo->furnished,
            $houseInfo->insulation,
            $houseInfo->status,
            $houseInfo->houseType
        ));
    // Execute the statement and check if it's successful
    if ($stmt->execute()) {
        return true;  // Success
    } else {
        return false; // Failure
    }
    }

    function getLastHouseIDFromDb($conn) {
        // Correct SQL query
        $sql = "SELECT MAX(houseID) AS lastHouseID FROM houses";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Return the maximum houseID
        return $row['lastHouseID'];
    }

    
    function closeConnection($conn) {
        $conn->close();
    }
}
?>