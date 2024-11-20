<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "connect.php";
// databaseController.php
if (!defined('DB_LOADED')) {
    define('DB_LOADED', true);

    function takeAllCities($conn){
        $sql = "SELECT DISTINCT il_adi FROM addresses ORDER BY il_adi";
        return $conn->query($sql);
    }

    function takeAllDistricts($conn, $city){
        $sql = "SELECT DISTINCT ilce_adi FROM addresses WHERE il_adi = '". $city . "' ORDER BY ilce_adi";
        return $conn->query($sql);
    }

    function takeAllNeighborhoods($conn, $district, $city){
        $sql = "SELECT DISTINCT mahalle_adi FROM addresses WHERE ilce_adi = '". $district ."'AND il_adi = '". $city . "' ORDER BY mahalle_adi";
        return $conn->query($sql);
    }

    function takeAllStreets($conn, $neighborhood, $district, $city){
        $sql = "SELECT DISTINCT sokak_adi FROM addresses WHERE mahalle_adi = '". $neighborhood . "' AND ilce_adi = '". $district . "' AND il_adi = '". $city . "' ORDER BY sokak_adi";
        return $conn->query($sql);
    }

    function getLastFiveHousesFromDb($conn){
        $sql = "SELECT * FROM houses WHERE status = 'Available' ORDER BY houseID DESC LIMIT 5";
        return $conn->query($sql);
    }

    function getCitiesFromDb($conn){
        $sql = "SELECT DISTINCT city FROM houses";
        return $conn->query($sql);
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
        $sql = "SELECT * FROM homes WHERE id = " . $id;
        return $conn->query($sql);
    }

    function getHomesByType($conn, $type) {
        $sql = "SELECT * FROM houses WHERE type = ". $type;
        return $conn->query($sql);
    }

    function get_pendingHouses($conn) {
        $sql = "SELECT * FROM houses WHERE status = 'pending'";
        return $conn->query($sql);
    }

    function changeStatus_toApprove($conn, $houseInfoID) {
        $sql = "UPDATE houses SET status = 'approved' WHERE houseID = ". $houseInfoID;
        $conn->query($sql);
    }

    function changeStatus_toCancel($conn, $houseInfoID) {
        $sql = "UPDATE houses SET status = 'cancelled' WHERE houseID = ". $houseInfoID;
        $conn->query($sql);
    }

    function createHouseListingToDb($houseInfo, $conn) {
        // Prepare the SQL statement with correct syntax
        $sql = "INSERT INTO houses (
        ownerID, title, description, numOfRooms, numOfBathroom, numOfBedroom, price, city, district, neighborhood, street, 
        floor, totalFloor, area, lat, lng, isSale, 
        fiberInternet, airConditioner, floorHeating, fireplace, terrace, satellite, parquet, steelDoor, furnished, insulation, status, houseType
    ) VALUES (". $houseInfo->ownerID . ",
            '" . $houseInfo->title . "',
            '" . $houseInfo->description . "',
            '" . $houseInfo->numOfRooms . "',
            1, -- numOfBathroom
            1, -- numOfBedroom
            " . $houseInfo->price . ",
            '" . $houseInfo->city . "',
            '" . $houseInfo->district . "',
            '" . $houseInfo->neighborhood . "',
            '" . $houseInfo->street . "',
            " . $houseInfo->floor . ",
            " . $houseInfo->totalFloor . ",
            " . $houseInfo->area . ",
            " . $houseInfo->lat . ",
            " . $houseInfo->lng . ", 
            " . $houseInfo->isSale . ",
            " . $houseInfo->fiberInternet . ",
            " . $houseInfo->airConditioner . ",
            " . $houseInfo->floorHeating . ",
            " . $houseInfo->fireplace . ",
            " . $houseInfo->terrace . ",
            " . $houseInfo->satellite . ",
            " . $houseInfo->parquet . ",
            " . $houseInfo->steelDoor . ",
            " . $houseInfo->furnished . ",
            " . $houseInfo->insulation . ",
            '" . $houseInfo->status . "',
            '" . $houseInfo->houseType . "'
        )";

        if ($conn->query($sql)) {
            echo "House record inserted successfully!";
            return true;
        } else {
            echo "Error inserting record: " . $conn->error;
            return false;
        }
    }

    function getLastHouseIDFromDb($conn) {
        // Correct SQL query
        $sql = "SELECT MAX(houseID) AS lastHouseID FROM houses";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $lastID = $row['lastHouseID'];
        return  $lastID;
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
        $sql = "SELECT userID FROM users WHERE email = '" . $email . "' AND password = '" . $password . "'";
        return $conn->query($sql);
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
        $sql = "INSERT INTO users (name, surname, email, phone, password, city, district, neighborhood, isActive) 
        VALUES (".
            "'". $name ."',".
            "'". $surname ."',".
            "'". $email ."',".
            "'". $phone ."',".
            "'". $password ."',".
            "'". $city ."',".
            "'". $district ."',".
            "'". $neighborhood ."',".
            $isActive.")";
        /*$stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $name, $surname, $email, $phone, $password, $city, $district, $neighborhood, $isActive);
        $stmt->execute();*/
        $conn->query($sql);
        return true;
    }


    /*Mehmet*/
    function getUserInfoFromDb($conn, $userID) {
        $sql = "SELECT * FROM users WHERE userID = " . $userID;
        return $conn->query($sql);
    }

    /*Ali*/
    function updateUserInfoInDb($conn, $name, $surname, $phone, $email, $city, $district, $neighborhood, $userId)
    {
        $sql = "UPDATE users SET name='".$name."', surname='".$surname."', phone='".$phone."', email='".$email."', city='".$city."', district='".$district."', neighborhood='".$neighborhood."', isActive = 1"." WHERE userID=".$userId;
        echo $sql;
        return $conn->query($sql);
    }

    /*Ali*/
    function updatePasswordInDb($conn, $password, $userId)
    {
        $sql = "UPDATE users SET password='".$password."' WHERE userID=".$userId;
        return $conn->query($sql);
    }
}
?>