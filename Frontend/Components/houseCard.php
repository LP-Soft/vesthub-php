<?php
include '../../Database/databaseController.php';
function displayHouseCard($house, $service) {
    // Create full address by concatenating fields
    $fullAddress = htmlspecialchars($house['street']) . ', ' .
        htmlspecialchars($house['neighborhood']) . ', ' .
        htmlspecialchars($house['district']) . ' / ' .
        htmlspecialchars($house['city']);

    // Output the HTML for the house card directly
    ?>
    <div class="home-card" onclick="window.location.href='houseDetailsPage.php?id=<?php echo $house['houseID']; ?>'">
        <link rel="stylesheet" href="../Styles/houseCard.css">
        <!-- <img src="photos/<?php echo $house['houseID']; ?>-1.png" alt="House Image"> -->
        <img src="../../house-images/dummy.png" alt="House Image">
        <div class="home-details">
            <h3><?php echo htmlspecialchars($house['title']); ?></h3>
            <h5><?php echo htmlspecialchars($house['price']); ?> ₺ </h5>
            <?php if($service == 0) { ?> <!-- user servisinden geliyorsa -->
                <p><?php echo $fullAddress; ?></p>
            <?php } else { ?>
                <button onclick="event.stopPropagation(); window.location.href='adminPanel.php?reject=<?php echo $house['houseID']; ?>'" style="background-color: #FF4245">Reject</button>
                <button onclick="event.stopPropagation(); window.location.href='adminPanel.php?approve=<?php echo $house['houseID']; ?>'" style="background-color: #3ED736">Approve</button>
            <?php } ?>
        </div>
    </div>
    <?php
}
