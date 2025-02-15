<?php
include "../../Database/databaseController.php";

function generateVerificationCode()
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function insertAccount($name, $surname, $email, $phone, $password, $city, $district, $neighborhood)
{
    //hash password before inserting
    $password = password_hash($password, PASSWORD_DEFAULT);
    $result = insertAccountInDb($GLOBALS['conn'], $name, $surname, $email, $phone, $password, $city, $district, $neighborhood);
}

?>