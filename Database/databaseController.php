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

    function createHouseListing($house, $conn) {
         var_dump($house);
        // Prepare the SQL statement with correct syntax
        $sql = "INSERT INTO houses (
        ownerID, title, description, numOfRooms, numOfBathroom, numOfBedroom, price, city, district, neighborhood, street, 
        floor, totalFloor, area, lat, lng, isSale, 
        fiberInternet, airConditioner, floorHeating, fireplace, terrace, satellite, parquet, steelDoor, furnished, insulation, status, houseType
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error); // Exit if there's an error
        }

        // Define additional parameters
        $ownerID = 1; // or retrieve this dynamically
        $lat = 40.7128; // example latitude
        $lng = -74.0060; // example longitude
        $numOfBathroom = 1;
        $numOfBedroom = 1;

        if (!$stmt->bind_param(
            'isssiiissssiiiddiiiiiiiiiiiss', // Data types: i for int, s for string, d for double
            $ownerID,
            $house['title'],
            $house['description'],
            $house['numOfRooms'],
            $numOfBathroom,
            $numOfBedroom,
            $house['price'],
            $house['city'],
            $house['district'],
            $house['neighborhood'],
            $house['street'],
            $house['floor'],
            $house['totalFloor'],
            $house['area'],
            $lat,
            $lng,
            $house['isSale'],
            $house['fiberInternet'],
            $house['airConditioner'],
            $house['floorHeating'],
            $house['fireplace'],
            $house['terrace'],
            $house['satellite'],
            $house['parquet'],
            $house['steelDoor'],
            $house['furnished'],
            $house['insulation'],
            $house['status'],
            $house['houseType']
        )) {
            die("Error binding parameters: " . $stmt->error); // Exit if there's an error
        }

        $stmt->close();
    }

    function closeConnection($conn) {
        $conn->close();
    }
}
?>