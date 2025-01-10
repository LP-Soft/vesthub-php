<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../Components/houseCard.php';
include '../../Backend/Utilities/sendMail.php';
include '../../Backend/adminPanelService.php';
include('../Components/header.php');

if (!isset($_SESSION['userID'])) {
    header("Location: loginPage.php");
}

if (isset($_GET['approve'])) {
    $houseID = $_GET['approve'];
    approveHouses($houseID);
    
    // Get house details
    $ownerEmailResult = getEmailChoosenHouse($houseID);
    $titleResult = getTitleForEmail($houseID); // Changed variable name to match function
    
    // Debug logging
    error_log("Email Result: " . print_r($ownerEmailResult, true));
    error_log("Title Result: " . print_r($titleResult, true));

    // Check both results and fetch data
    if ($ownerEmailResult && $titleResult) {
        $emailRow = $ownerEmailResult->fetch_assoc();
        $titleRow = $titleResult->fetch_assoc();
        
        if ($emailRow && $titleRow) {
            $ownerEmail = $emailRow['email'];
            $houseTitle = $titleRow['title']; // Changed variable name
            
            try {
                sendEmail(
                    $ownerEmail, 
                    "VestHub User", 
                    "House Listing Approved", 
                    "Your house listing '$houseTitle' has been approved."
                );
                error_log("Email sent successfully to: " . $ownerEmail);
            } catch (Exception $e) {
                error_log("Failed to send email: " . $e->getMessage());
            }
        }
    }
    
    header("Location: adminPanelPage.php");
    exit();
}

if (isset($_GET['reject'])) {
    $houseID = $_GET['reject'];
    $ownerEmailResult = getEmailChoosenHouse($houseID);
    $titleEmailResult = getTitleForEmail($houseID);
    rejectHouses($houseID);
    if ($ownerEmailResult && $titleEmailResult) {
        $emailRow = $ownerEmailResult->fetch_assoc();
        $titleRow = $titleEmailResult->fetch_assoc();
        if($emailRow && $titleRow) {
            $ownerEmail = $emailRow['email'];
            $houseTitle = $titleRow['title'];
            try {
                sendEmail($ownerEmail, "VestHub User", "House Listing Rejected", "Your house listing '$houseTitle' has been rejected.");
                error_log("Email sent successfully to: " . $ownerEmail);
            } catch (Exception $e) {
                error_log("Failed to send email: " . $e->getMessage());
            }
        }
    }
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