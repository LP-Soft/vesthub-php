<?php
include "../../Database/databaseController.php";

function getFavoriteHouses($userID)
{
    return getFavoriteHousesFromDb($GLOBALS['conn'], $userID);
}
?>