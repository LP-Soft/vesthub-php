<?php
include "../../Database/databaseController.php";
// require_once '../../Classes/userInfo.php';
// use Classes\User;

/*
function getUserFromEmailandPassword($email, $password)
{
    // Run the query to get the user result
    $userResult = checkLoginCredentialsFromDb($GLOBALS['conn'], $email, $password);
    
    // Check if we got a result
    if ($userResult->num_rows > 0) {
        // Fetch the user data as an associative array
        $userData = $userResult->fetch_assoc();
        
        // Create an instance of the User class with the data
        $user = new User($userData);
        
        // Return the User object (optional)
        return $user;
    } else {
        // Return null if no user was found
        return null;
    }
}
*/
function checkLoginCredentials($email, $password)
{
    // Run the query to get the user result
    $userResult = checkLoginCredentialsFromDb($GLOBALS['conn'], $email, $password);
    
    // Check if we got a result
    if ($userResult->num_rows > 0) {
        // Fetch the user data as an associative array
        $userData = $userResult->fetch_assoc();
        
        // Return only the userID
        return $userData['userID'];
    } else {
        // Return null if no user was found
        return null;
    }
}


function checkAccountExists($email)
{
    $userResult = checkAccountExistFromDb($GLOBALS['conn'], $email);

    // console log the result
    echo "<script>console.log('userResult: " . $userResult . "');</script>";
    
    if ($userResult->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}



?>
