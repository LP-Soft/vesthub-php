<!-- housecard.php -->
<?php
include '../../Database/databaseController.php';
?>
<div class="home-card">
    <link rel="stylesheet" href="../Styles/houseCard.css">
    <!-- <img src="photos/<?php echo $home['id']; ?>-1.png" alt="House Image"> -->
    <img src="../../house-images/dummy.png" alt="House Image">
    <div class="home-details">
        <h3><?php echo htmlspecialchars($home['title']); ?></h3>
        <h5><?php echo htmlspecialchars($home['price']); ?> TL </h5>
        <p><?php echo htmlspecialchars($home['fullAddress']); ?></p>
    </div>
</div>

