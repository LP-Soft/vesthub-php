<?php
include '../../Database/databaseController.php';
?>
<link rel="stylesheet" href="../Styles/adminPanel.css">
<div>
    <img src="../../house-images/dummy.png" alt="House Image">
    <div class="adminPanel.css">
        <p class="h1Title"><?= $house['title'] ?><p/>
        <p><?= $house['price'] . '₺' ?></p>
        <button onclick="window.location.href='adminPanel.php?approve=<?= $house['id'] ?>'" style="background-color: green; color: white; border: none; border-radius: 10px; padding: 10px 20px; margin-right: 10px">Approve</button>
        <button onclick="window.location.href='adminPanel.php?reject=<?= $house['id'] ?>'" style="background-color: red; color: white; border: none; border-radius: 10px; padding: 10px 20px">Reject</button>
    </div>
</div>