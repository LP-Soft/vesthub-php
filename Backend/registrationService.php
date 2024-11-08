<?php
include "../../Database/databaseController.php";

function checkAccountExists($email)
{
    $userResult = checkAccountExistFromDb($GLOBALS['conn'], $email);
    
    if ($userResult->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

?>