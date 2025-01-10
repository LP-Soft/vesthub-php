<?php
require_once '../../Classes/userInfo.php';
use Classes\User;


function getUserInfo($userID) {

    // Fetch house details from the database
    $result = getUserInfoFromDb($GLOBALS['conn'], $userID);

    // Check if the house was found
    if ($result && $row = $result->fetch_assoc()) {
        $user = new User([
            'name' => $row['name'],
            'surname' => $row['surname'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'password' => $row['password'],
            'city' => $row['city'],
            'isActive' => $row['isActive'],
            'district' => $row['district'],
            'neighborhood' => $row['neighborhood'],
        ]);

        return $user;
    } else {
        echo "User not found";
    }
}


?>