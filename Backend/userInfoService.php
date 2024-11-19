<?php
include "../../Database/databaseController.php";
function updateUserInfo($name, $surname, $phone, $email, $city, $district, $neighborhood, $userId)
{
    $conn = $GLOBALS['conn'];
    updateUserInfoInDb($conn,$name, $surname, $phone, $email, $city, $district, $neighborhood, $userId);
}

function updatePassword($password, $userId)
{
    $conn = $GLOBALS['conn'];
    updatePasswordInDb($conn, $password, $userId);
}