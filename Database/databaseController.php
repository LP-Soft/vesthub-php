<?php
require_once "connect.php";
// databaseController.php
if (!defined('DB_LOADED')) {
    define('DB_LOADED', true);

    function takeAllCities($conn){
        $sql = "SELECT DISTINCT il_adi FROM iller ORDER BY il_adi";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }

    function takeAllDistricts($conn, $city){
        $sql = "SELECT DISTINCT ilce_adi FROM ilceler WHERE il_adi = ? ORDER BY ilce_adi";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $city);
        $stmt->execute();
        return $stmt->get_result();

    }

    function takeAllNeighborhoods($conn, $district){
        $sql = "SELECT DISTINCT mahalle_adi FROM mahalleler WHERE ilce_adi = ? ORDER BY mahalle_adi";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $district);
        $stmt->execute();
        return $stmt->get_result();
    }

    function takeAllStreets($conn, $neighborhood){
        $sql = "SELECT DISTINCT sokak_adi FROM sokaklar WHERE mahalle_adi = ? ORDER BY sokak_adi";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $neighborhood);
        $stmt->execute();
        return $stmt->get_result();
    }

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

    function getNeighborhoodsFromDb($conn, $district){
        $sql = "SELECT DISTINCT neighborhood FROM houses WHERE district = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $district);
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

    function getHousesByOwnerFromDb($conn, $ownerID){
        $sql = "SELECT * FROM houses WHERE ownerID = " . $ownerID;
        return $conn->query($sql);
    }

    function getFavoriteHousesByOwnerFromDb($conn, $userID)
    {
        $sql = "SELECT h.* FROM houses h 
            INNER JOIN favorites f ON h.houseID = f.houseID 
            WHERE f.userID = " . $userID;
        return $conn->query($sql);
    }

    function getHouseDetailsFromDb($conn, $houseID)
    {
        $sql = "SELECT * FROM houses WHERE houseID = " . $houseID;
        return $conn->query($sql);
    }

    /*Mehmet*/
    function checkLoginCredentialsFromDb($conn, $email, $password)
    {
        $sql = "SELECT userID FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        return $stmt->get_result();
    }

    /*Mehmet*/
    function checkAccountExistFromDb($conn, $email)
    {
        $sql = "SELECT userID FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result();
    }

    /*Mehmet*/
    function insertAccountDb($conn, $name, $surname, $email, $phone, $password, $city, $district, $neighborhood)
    {
        $isActive = 1;
        $sql = "INSERT INTO users (name, surname, email, phone, password, city, district, neighborhood, isActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $name, $surname, $email, $phone, $password, $city, $district, $neighborhood, $isActive);
        $stmt->execute();
        return true;
    }


    /*Mehmet*/
    function getUserInfoFromDb($conn, $userID) {
        $sql = "SELECT * FROM users WHERE userID = " . $userID;
        return $conn->query($sql);
    }

    
}
?>