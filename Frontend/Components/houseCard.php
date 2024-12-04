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
        <?php $image_paths = "../../house-images/"?>
        <?php if(!is_dir("../../house-images/".$house['houseID']."/")) { ?>
            <img src= "../../house-images/dummy.png" alt="House Image">
        <?php } else { ?>
                    <?php if(file_exists($image_paths.$house['houseID']."/1.png")) {
                        $image_path = $image_paths . $house['houseID'] . "/1.png";
                    }
                    elseif (file_exists($image_paths.$house['houseID']."/1.jpg")){
                        $image_path = $image_paths.$house['houseID']."/1.jpg";
                    }
                    else{
                        $image_path = $image_paths."dummy.png";
                    }?>
            <img src="<?php echo $image_path ?>" alt="House Image">
        <?php } ?>

        <div class="home-type-label">
            <?php if($house['isSale'] == 1) { ?>
                <button class= "typeStatusButton" style="background-color: #B7C094">Sale</button>
            <?php } else { ?>
                <button class= "typeStatusButton" style="background-color: #d78f69">Rent</button>
            <?php } ?>
        </div>
        <div class="home-status-label">
            <?php if($service == 2){?>
                <button class= "typeStatusButton" style="background-color: <?php echo $house['status'] == 'Rejected' ? '#FF4245' : ($house['status'] == 'Pending' ? '#FFDF00' : '#3ED736'); ?>"><?php echo $house['status'] ?></button>
            <?php } ?>
        </div>
        <div class="home-details">
            <h3><?php echo htmlspecialchars($house['title']); ?></h3>
            <h5><?php echo htmlspecialchars($house['price']); ?> ₺ </h5>
            <?php if($service == 0) { ?> <!-- user servisinden geliyorsa -->
                <p><?php echo $fullAddress; ?></p>
            <?php } elseif ($service == 1) { ?>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <button class="adminButton" onclick="event.stopPropagation(); window.location.href='adminPanelPage.php?reject=<?php echo $house['houseID']; ?>'" style="background-color: #FF4245">Reject</button>
                    <button class="adminButton" onclick="event.stopPropagation(); window.location.href='adminPanelPage.php?approve=<?php echo $house['houseID']; ?>'" style="background-color: #3ED736">Approve</button>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>