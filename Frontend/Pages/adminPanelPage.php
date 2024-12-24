<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../Components/houseCard.php';
include '../../Backend/Utilities/sendMail.php';
include '../../Backend/adminPanelService.php';
if (isset($_GET['approve'])) {
    $houseID = $_GET['approve'];
    approveHouses($houseID);

    // Get email result
    $ownerEmailResult = getEmailChoosenHouse($houseID);
    
    if ($ownerEmailResult && $emailRow = $ownerEmailResult->fetch_assoc()) {
        $ownerEmail = $emailRow['email'];
        // Send email only once
        sendEmail($ownerEmail, "Request", "Acknowledge", "Your house request has been approved.");
    }

    header("Location: adminPanelPage.php");
    exit();
}

if (isset($_GET['reject'])) {
    $houseID = $_GET['reject'];
    rejectHouses($houseID);
    header("Location: adminPanelPage.php"); // Redirect to prevent resubmission
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../Styles/adminPanelPage.css">
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
</div>
</body>

<?php include('../Components/footer.php'); ?> <!-- Footer kısmı dahil ediliyor -->