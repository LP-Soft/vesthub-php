<?php
require_once '../Components/header.php';
require_once '../../Backend/myListingsService.php';
require_once '../Components/houseCard.php';
//Su anlik user giris yapmadigi icin ownderID static 2 olarak belirlendi.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings Page</title>
    <link rel="stylesheet" href="../Styles/myListingsPage.css">
</head>
<body>
<div class="content">
    <div class="my-listings">
        <h1 class="my-listings-text">My Listings</h1>
        <div class="house-cards">
            <?php
            // Fetch all homes

            if (isset($_SESSION['userID']))
            {
                $ownerID = $_SESSION['userID'];
                $result = getHousesByOwner($ownerID);
                // Loop through the result set and include homecard.php
                if ($result && $result->num_rows > 0) {
                    while ($house = $result->fetch_assoc()) {
                        displayHouseCard($house, 2);
                    }
                }
            }
            else {
                echo "No homes available.";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>

<?php
//closeConnection($conn);
include '../Components/footer.php';
?>