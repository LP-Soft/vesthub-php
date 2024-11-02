<?php

// CREATE USER 'lpsoft'@'localhost' IDENTIFIED BY 'LpSoft123';
// sonra bu usera yetkileri verin
$servername = "localhost";
$username = "lpsoft";
$password = "LpSoft123";
$dbname = "vesthub";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
