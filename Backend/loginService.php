<?php
include "../../Database/databaseController.php";
function checkLoginCredentials($email, $password)
{
    // Run the query to get the user result
    $userResult = checkLoginCredentialsFromDb($GLOBALS['conn'], $email, $password);
    
    // First check if we got a valid result
    if ($userResult && $userResult->num_rows > 0) {
        // Fetch the user data
        $userData = $userResult->fetch_assoc();
        // Verify password
        if (password_verify($password, $userData['password'])) {
            // Return user data array
            return array(
                'userID' => $userData['userID'],
                'role' => $userData['role']
            );
        }
    }
    return null;
}


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
