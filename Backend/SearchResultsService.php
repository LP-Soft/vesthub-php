<?php
include "../../Database/databaseController.php";

function getFilteredHouses($filters)
{
    return getFilteredHousesDB($GLOBALS['conn'], $filters);
}


