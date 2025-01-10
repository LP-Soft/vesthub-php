<?php
include "../../Database/databaseController.php";
function PendigHouse()
{
    return getPendingHousesFromDb($GLOBALS['conn']);
}

function approveHouses($house_id){
    $conn = $GLOBALS['conn'];
    changeStatusToApprovedInDb($conn, $house_id);
}

function rejectHouses($house_id) {
    $conn = $GLOBALS['conn'];
    changeStatusToRejectedInDb($conn, $house_id);
}

function getEmailChoosenHouse($house_id) {
    $conn = $GLOBALS['conn'];
    return getEmailByHouseId($conn, $house_id);
}

function getTitleForEmail($house_id) {
    $conn = $GLOBALS['conn'];
    return getTitle($conn, $house_id);
}

