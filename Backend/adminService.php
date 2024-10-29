<?php
include "../../Database/databaseController.php";
function PendigHouse()
{
    return get_pendingHouses($GLOBALS['conn']);
}

function approveHouses($house_id){
    $conn = $GLOBALS['conn']; // Get the database connection
    changeStatus_toApprove($conn, $house_id);
}

function rejectHouses($house_id) {
    $conn = $GLOBALS['conn']; // Get the database connection
    changeStatus_toCancel($conn, $house_id);
}