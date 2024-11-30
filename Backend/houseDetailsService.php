<?php
// Include the database controller and houseInfo class
include "../../Database/databaseController.php";
require_once '../../Classes/houseInfo.php'; // Adjust the path as needed

use Classes\houseInfo;

function getHouseDetails($houseID) {

    // Fetch house details from the database
    $result = getHouseDetailsFromDb($GLOBALS['conn'], $houseID);

    // Check if the house was found
    if ($result && $row = $result->fetch_assoc()) {
        // Map SQL data to houseInfo properties
        $house = new houseInfo([
            'title' => $row['title'],
            'description' => $row['description'],
            'numOfRooms' => $row['numOfRooms'],
            'numOfBathroom' => $row['numOfBathroom'],
            'numOfBedroom' => $row['numOfBedroom'],
            'price' => $row['price'],
            'city' => $row['city'],
            'district' => $row['district'],
            'neighborhood' => $row['neighborhood'],
            'street' => $row['street'],
            'houseType' => $row['houseType'],
            'floor' => $row['floor'],
            'totalFloor' => $row['totalFloor'],
            'area' => $row['area'],
            'keyFeatures' => [], // This will be populated below
            'isSale' => $row['isSale'],
            'ownerID' => $row['ownerID'],
            'lat' => $row['lat'],
            'lng' => $row['lng'],
        ]);

        // Populate key features
        $house->fiberInternet = $row['fiberInternet'];
        $house->airConditioner = $row['airConditioner'];
        $house->floorHeating = $row['floorHeating'];
        $house->fireplace = $row['fireplace'];
        $house->terrace = $row['terrace'];
        $house->satellite = $row['satellite'];
        $house->parquet = $row['parquet'];
        $house->steelDoor = $row['steelDoor'];
        $house->furnished = $row['furnished'];
        $house->insulation = $row['insulation'];

        // Debugging: Echo house details
        return $house;
    } else {
        echo "House not found or invalid house ID.";
    }
}


?>
