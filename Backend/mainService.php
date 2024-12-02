<?php
include "../../Database/databaseController.php";

function getLastFiveHouses()
{
    $userID = 0;
    if(isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];
    }
    return getLastFiveHousesFromDb($GLOBALS['conn'], $userID);
}