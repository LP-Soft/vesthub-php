<?php
require_once "connect.php";
if (!defined('DB_LOADED')) {
    define('DB_LOADED', true);

    function takeAllCitiesFromDb($conn){
        $sql = "SELECT DISTINCT il_adi FROM addresses ORDER BY il_adi";
        return $conn->query($sql);
    }

    function takeAllDistrictsFromDb($conn, $city){
        $sql = "SELECT DISTINCT ilce_adi FROM addresses WHERE il_adi = '". $city . "' ORDER BY ilce_adi";
        return $conn->query($sql);
    }

    function takeAllNeighborhoodsFromDb($conn, $district, $city){
        $sql = "SELECT DISTINCT mahalle_adi FROM addresses WHERE ilce_adi = '". $district ."'AND il_adi = '". $city . "' ORDER BY mahalle_adi";
        return $conn->query($sql);
    }

    function takeAllStreetsFromDb($conn, $neighborhood, $district, $city){
        $sql = "SELECT DISTINCT sokak_adi FROM addresses WHERE mahalle_adi = '". $neighborhood . "' AND ilce_adi = '". $district . "' AND il_adi = '". $city . "' ORDER BY sokak_adi";
        return $conn->query($sql);
    }

    function getLastTenHousesFromDb($conn, $userID){
        $sql = "SELECT * FROM houses WHERE status = 'Available' AND status != 'Deleted' ORDER BY houseID DESC LIMIT 10";
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

    function getAllHomesFromDb($conn) {
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

    function getPendingHousesFromDb($conn) {
        $sql = "SELECT * FROM houses WHERE status = 'Pending'";
        return $conn->query($sql);
    }

    function changeStatusToApprovedInDb($conn, $houseInfoID) {
        $sql = "UPDATE houses SET status = 'Available' WHERE houseID = ". $houseInfoID;
        $conn->query($sql);
    }

    function changeStatusToRejectedInDb($conn, $houseInfoID) {
        $sql = "UPDATE houses SET status = 'Rejected' WHERE houseID = ". $houseInfoID;
        $conn->query($sql);
    }

    function createHouseListingInDb($houseInfo, $conn) {
        // Prepare the SQL statement with correct syntax
        $sql = "INSERT INTO houses (
        ownerID, title, description, numOfRooms, numOfBathroom, numOfBedroom, price, city, district, neighborhood, street, 
        floor, totalFloor, area, lat, lng, isSale, 
        fiberInternet, airConditioner, floorHeating, fireplace, terrace, satellite, parquet, steelDoor, furnished, insulation, status, houseType
    ) VALUES (". $houseInfo->ownerID . ",
            '" . $houseInfo->title . "',
            '" . $houseInfo->description . "',
            '" . $houseInfo->numOfRooms . "',
            " . $houseInfo->numOfBathroom . ",
            " . $houseInfo->numOfBedroom . ",
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

    function editListingInDb($conn, $houseInfo) {
        // Prepare the SQL statement to update the house listing
        $sql = "UPDATE houses SET
        ownerID = " . (int)$houseInfo->ownerID . ",
        title = '" . $houseInfo->title . "',
        description = '" . $houseInfo->description . "',
        numOfRooms = '" . $houseInfo->numOfRooms . "',
        numOfBathroom = " . $houseInfo->numOfBathroom . ",
        numOfBedroom = " . $houseInfo->numOfBedroom . ",
        price = " . $houseInfo->price . ",
        city = '" . $houseInfo->city . "',
        district = '" . $houseInfo->district . "',
        neighborhood = '" . $houseInfo->neighborhood . "',
        street = '" . $houseInfo->street . "',
        floor = " . $houseInfo->floor . ",
        totalFloor = " . $houseInfo->totalFloor . ",
        area = " . $houseInfo->area . ",
        lat = " . $houseInfo->lat . ",
        lng = " . $houseInfo->lng . ",
        isSale = " . $houseInfo->isSale . ",
        fiberInternet = " . $houseInfo->fiberInternet . ",
        airConditioner = " . $houseInfo->airConditioner . ",
        floorHeating = " . $houseInfo->floorHeating . ",
        fireplace = " . $houseInfo->fireplace . ",
        terrace = " . $houseInfo->terrace . ",
        satellite = " . $houseInfo->satellite . ",
        parquet = " . $houseInfo->parquet . ",
        steelDoor = " . $houseInfo->steelDoor . ",
        furnished = " . $houseInfo->furnished . ",
        insulation = " . $houseInfo->insulation . ",
        status = '" . $houseInfo->status . "',
        houseType = '" . $houseInfo->houseType . "'
        WHERE houseID = " . $houseInfo->houseID;

        // Execute the SQL query and check if it was successful
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteHouseFromDb($conn, $houseID) {
        $sql = "UPDATE houses SET status = 'Deleted' WHERE houseID = " . $houseID;
        return $conn->query($sql);
    }

    function getLastHouseIDFromDb($conn) {
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
        $sql = "SELECT * FROM houses WHERE ownerID = " . $ownerID. " AND status != 'Deleted'";
        return $conn->query($sql);
    }

    function getFavoriteHousesByOwnerFromDb($conn, $userID)
    {
        $sql = "SELECT h.* FROM houses h 
            INNER JOIN favorites f ON h.houseID = f.houseID 
            WHERE f.userID = " . $userID. " AND h.status != 'Deleted'";
        return $conn->query($sql);
    }

    function getHouseDetailsFromDb($conn, $houseID)
    {
        $sql = "SELECT * FROM houses WHERE houseID = " . $houseID;
        return $conn->query($sql);
    }

    function checkLoginCredentialsFromDb($conn, $email, $password)
    {
        $sql = "SELECT userID, `role`, `password` FROM users WHERE email = '" . $email . "' AND isActive = 1";
        return $conn->query($sql);
    }

    function checkAccountExistFromDb($conn, $email)
    {
        $sql = "SELECT userID FROM users WHERE email = '" . $email . "'";
        return $conn->query($sql);
    }

    function insertAccountInDb($conn, $name, $surname, $email, $phone, $password, $city, $district, $neighborhood)
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
        $conn->query($sql);
        return true;
    }


    function getUserInfoFromDb($conn, $userID) {
        $sql = "SELECT * FROM users WHERE userID = " . $userID;
        return $conn->query($sql);
    }

    function updateUserInfoInDb($conn, $name, $surname, $phone, $email, $city, $district, $neighborhood, $userId)
    {
        $sql = "UPDATE users SET name='".$name."', surname='".$surname."', phone='".$phone."', email='".$email."', city='".$city."', district='".$district."', neighborhood='".$neighborhood."', isActive = 1"." WHERE userID=".$userId;
        return $conn->query($sql);
    }

    function updatePasswordInDb($conn, $password, $userId)
    {
        $sql = "UPDATE users SET password='".$password."' WHERE userID=".$userId;
        return $conn->query($sql);
    }

    function checkEmailInDb($conn, $email, $userId)
    {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' AND userID != " . $userId;
        return $conn->query($sql);
    }

    function getHouseInfoByIDFromDb($conn, $houseID, $city, $district, $neighborhood, $street){
        $sql = "SELECT * FROM houses WHERE houseID = " . $houseID. " AND city = '" . $city ."' AND district = '" . $district ."' AND neighborhood = '" . $neighborhood ."' AND street = '" . $street ."' AND status != 'Deleted'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }

    function deleteUserFromDb($conn, $userID)
    {
        $sql = "UPDATE users SET isActive = 0 WHERE userID = " . $userID;
        return $conn->query($sql);
    }

    function getFavoritedHousesFromDb($conn, $userID)
    {
        $sql = "SELECT * FROM favorites WHERE userID = " . $userID. " AND status != 'Deleted'";
        return $conn->query($sql);
    }

    function insertFavoritedHouseToDb($conn, $houseID, $userID)
    {
        $sql = "INSERT INTO favorites (userID, houseID) VALUES (" . $userID . ", " . $houseID . ")";
        return $conn->query($sql);
    }

    function deleteFavoritedHouseFromDb($conn, $houseID, $userID)
    {
        $sql = "DELETE FROM favorites WHERE userID = " . $userID . " AND houseID = " . $houseID;
        return $conn->query($sql);
    }

    function checkFavoritedHouseFromDb($conn, $houseID, $userID)
    {
        $sql = "SELECT * FROM favorites WHERE userID = " . $userID . " AND houseID = " . $houseID;
        return $conn->query($sql);
    }
    function getFilteredHousesDB($conn,$filters)
    {
        $userID = 0;
        if(isset($_SESSION['userID'])){
            $userID = $_SESSION['userID'];
        }
        global $conn;
        $whereConditions = [];
        if (isset($filters['isSale']) && $filters['isSale'] !== '') {
            $whereConditions[] = "isSale = '" . $filters['isSale'] . "'";
        }
        if (!empty($filters['city'])) {
            $whereConditions[] = "city = '" . $filters['city'] . "'";
        }
        if (!empty($filters['district'])) {
            $whereConditions[] = "district = '" . $filters['district']. "'";
        }
        if (!empty($filters['neighborhood'])) {
            $whereConditions[] = "neighborhood = '" . $filters['neighborhood'] . "'";
        }
        if (!empty($filters['house_type'])) {
            $whereConditions[] = "houseType = '" . $filters['house_type'] . "'";
        }
        $amenitiesConditions = [];
        if (!empty($filters['amenities']) && is_array($filters['amenities'])) {
            foreach ($filters['amenities'] as $amenity) {
                switch ($amenity) {
                    case 'Floor Heating':
                        $amenity = 'floorHeating';
                        break;
                    case 'Furnished':
                        $amenity = 'furnished';
                        break;
                    case 'Fiber Internet':
                        $amenity = 'fiberInternet';
                        break;
                    case 'Air Conditioner':
                        $amenity = 'airConditioner';
                        break;
                    case 'Fireplace':
                        $amenity = 'fireplace';
                        break;
                    case 'Satellite':
                        $amenity = 'satellite';
                        break;
                    case 'Steel Door':
                        $amenity = 'steelDoor';
                        break;
                    case 'Insulation':
                        $amenity = 'insulation';
                        break;
                }
                $amenitiesConditions[] = $amenity.'=' . '1';
            }
            if (!empty($amenitiesConditions)) {
                $whereConditions[] = "(" . implode(" AND ", $amenitiesConditions) . ")";
            }
        }
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

        $whereConditions[] = "status = 'Available'";
        $whereConditions[] = "ownerID != " . $userID;
        // Construct the WHERE clause
        $whereSQL = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

        $sql = "SELECT * FROM houses $whereSQL $orderBy";
        $result = $conn->query($sql);

        return $result;
    }

    function addFavoriteToDb($conn, $houseID, $userID)
    {
        $sql = "INSERT INTO favorites (userID, houseID) VALUES (" . $userID . ", " . $houseID . ")";
        return $conn->query($sql);
    }

    function removeFavoriteFromDb($conn, $houseID, $userID)
    {
        $sql = "DELETE FROM favorites WHERE userID = " . $userID . " AND houseID = " . $houseID;
        return $conn->query($sql);
    }

    function getEmailByHouseId($conn, $house_id) {
        $sql = "SELECT email FROM users WHERE userID = (SELECT ownerID FROM houses WHERE houseID = " . $house_id . ")";
        return $conn->query($sql);
    }

    function markHouseAsSold($houseID) {
        $sql = "UPDATE houses SET status = 'Sold' WHERE houseID = ?";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bind_param("i", $houseID);
        return $stmt->execute();
    }

    function markHouseAsRented($houseID) {
        $sql = "UPDATE houses SET status = 'Rented' WHERE houseID = ?";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bind_param("i", $houseID);
        return $stmt->execute();
    }

    function getTitle($conn, $house_id){
        $sql = "SELECT title FROM houses WHERE houseID = " . $house_id;
        return $conn->query($sql);
    }
}
?>