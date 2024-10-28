<?php
// databaseController.php
if (!defined('DB_LOADED')) {
    define('DB_LOADED', true);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "vesthub";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function getAllHomes($conn) {
        $sql = "SELECT * FROM houses";
        return $conn->query($sql);
    }

    function getHomeById($conn, $id) {
        $sql = "SELECT * FROM homes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    function getHomesByType($conn, $type) {
        $sql = "SELECT * FROM houses WHERE type = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $type);
        $stmt->execute();
        return $stmt->get_result();
    }

    function closeConnection($conn) {
        $conn->close();
    }
}
?>