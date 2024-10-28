<!-- homecard.php -->
<?php
include '../../Database/databaseController.php';
?>
<div class="home-card">
    <link rel="stylesheet" href="../Styles/homeCard.css">
    <img src="photos/<?php echo $home['id']; ?>-1.png" alt="House Image">
    <div class="home-details">
        <h3><?php echo htmlspecialchars($home['title']); ?></h3>
        <p><?php echo htmlspecialchars($home['address']); ?></p>
    </div>
</div>

