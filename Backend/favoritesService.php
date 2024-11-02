<?php
include "../../Database/databaseController.php";

function getFavoriteHousesByOwner($userID)
{
    return getFavoriteHousesByOwnerFromDb($GLOBALS['conn'], $userID);
}
?>