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

function deleteUser($userID)
{
    $conn = $GLOBALS['conn'];
    deleteUserFromDb($conn, $userID);
}

function checkEmail($email, $userId)
{
    $conn = $GLOBALS['conn'];
    $response= checkEmailInDb($conn, $email, $userId);
    return $response->num_rows > 0;
}