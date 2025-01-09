<?php

require_once __DIR__ . '/../Database/databaseController.php';
require_once __DIR__ . '/../Classes/houseInfo.php';

use Classes\houseInfo;

function addFavorite($houseID, $userID)
{
    return addFavoriteToDb($GLOBALS['conn'], $houseID, $userID);
}

function removeFavorite($houseID, $userID)
{
    return removeFavoriteFromDb($GLOBALS['conn'], $houseID, $userID);
}

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
            'houseID' => $row['houseID'],
            'lat' => $row['lat'],
            'lng' => $row['lng'],
            'status' => $row['status'],
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

if (isset($_POST['action'], $_POST['houseID'], $_POST['userID']))
{
    $action = $_POST['action'];
    $houseID = $_POST['houseID'];
    $userID = $_POST['userID'];

    try {
        if ($action === 'add') {
            // Call function to add favorite
            $result = addFavorite($houseID, $userID);

            // Check if the operation was successful
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add to favorites']);
            }
        } elseif ($action === 'remove') {
            // Call function to remove favorite
            $result = removeFavorite($houseID, $userID);

            // Check if the operation was successful
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove from favorites']);
            }
        } else {
            // Invalid action
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } catch (Exception $e) {
        // Catch any unexpected errors
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

}

function markHouseAsSoldOrRented($houseID, $isSale) {
    if ($isSale) {
        return markHouseAsSold($houseID);
    } else {
        return markHouseAsRented($houseID);
    }
}

// Add this to the existing POST handler section
if (isset($_POST['action'], $_POST['houseID'], $_POST['isSale'])) {
    $action = $_POST['action'];
    $houseID = $_POST['houseID'];
    $isSale = $_POST['isSale'];

    // Handle mark as sold/rented
    if ($action === 'markInactive') {
        try {
            $result = markHouseAsSoldOrRented($houseID, $isSale);
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update house status']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

?>
