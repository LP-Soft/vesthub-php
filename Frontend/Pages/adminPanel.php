<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../Components/houseCard.php';
include '../../Backend/adminService.php';
if (isset($_GET['approve'])) {
    $houseID = $_GET['approve'];
    approveHouses($houseID);
    header("Location: adminPanel.php"); // Redirect to prevent resubmission
    exit();
}

if (isset($_GET['reject'])) {
    $houseID = $_GET['reject'];
    rejectHouses($houseID);
    header("Location: adminPanel.php"); // Redirect to prevent resubmission
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../Styles/adminPanel.css">
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="../Styles/houseCard.css">
</head>
<body>
<?php include('../Components/header.php'); ?> <!-- Header included -->
<div class="Content">
    <h1>Waiting For Approval</h1>
    <div class="HouseContent">
    <?php
        $pendingHouses = PendigHouse();
        if ($pendingHouses) {
            while ($house = $pendingHouses->fetch_assoc()) {
                displayHouseCard($house, 1);
            }
        } else {
            echo "<p>No pending houses found.</p>";
        }
        ?>        
</div>
<?php include('../Components/footer.php'); ?> <!-- Footer kısmı dahil ediliyor -->