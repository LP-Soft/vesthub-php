<?php

include "../../Database/databaseController.php";
function getHousesByOwner($ownerID)
{
    return getHousesByOwnerFromDb($GLOBALS['conn'], $ownerID);
}

?>