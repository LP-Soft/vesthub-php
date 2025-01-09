<?php
include "../../Database/databaseController.php";

function getLastTenHouses()
{
    $userID = 0;
    if(isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];
    }
    return getLastTenHousesFromDb($GLOBALS['conn'], $userID);
}