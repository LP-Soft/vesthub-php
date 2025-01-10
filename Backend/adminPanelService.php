<?php
include "../../Database/databaseController.php";
function PendigHouse()
{
    return getPendingHousesFromDb($GLOBALS['conn']);
}

function approveHouses($house_id){
    $conn = $GLOBALS['conn']; // Get the database connection
    changeStatusToApprovedInDb($conn, $house_id);
}

function rejectHouses($house_id) {
    $conn = $GLOBALS['conn']; // Get the database connection
    changeStatusToRejectedInDb($conn, $house_id);
}

function getEmailChoosenHouse($house_id) {
    $conn = $GLOBALS['conn']; // Get the database connection
    return getEmailByHouseId($conn, $house_id);
}

function getTitleForEmail($house_id) {
    $conn = $GLOBALS['conn']; // Get the database connection
    return getTitle($conn, $house_id);
}



// email gönderilecek kişinin email adresini getir.
