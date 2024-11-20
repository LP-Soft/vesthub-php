<?php
include "../../Database/databaseController.php";
require_once "../../Frontend/Pages/editListingPage.php";

function editListing($houseInfo, $houseID){
    echo "servise geldi";
    editListingInDb($GLOBALS['conn'],$houseInfo, $houseID);
}
?>