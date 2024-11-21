<?php
include "../../Database/databaseController.php";
require_once "../../Frontend/Pages/editListingPage.php";

function editListing($houseInfo){
    editListingInDb($GLOBALS['conn'],$houseInfo);
}
?>