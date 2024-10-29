<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../Styles/adminPanel.css">
</head>
<?php include('../Components/header.php'); ?> <!-- Header kısmı dahil ediliyor -->
<div class="Content">
    <h1>Waiting For Approval</h1>
    <div class="HouseContent">
        <?php
        include '../../Database/databaseController.php';
        $pendingHouses = get_pendingHouses($conn);
        while ($house = $pendingHouses->fetch_assoc()) {
            include '../Components/adminHouseCard.php';
        }
        ?>        
</div>
<?php include('../Components/footer.php'); ?> <!-- Footer kısmı dahil ediliyor -->