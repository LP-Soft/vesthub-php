<?php
include "../Database/databaseController.php";
function getLastFiveHouses()
{
    return getLastFiveHousesFromDb($GLOBALS['conn']);
}