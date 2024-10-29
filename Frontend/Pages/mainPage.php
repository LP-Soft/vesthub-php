<?php
require '../Components/header.php';
include '../../Backend/mainPageService.php';
include '../Components/houseCard.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Main Page</title>
        <link rel="stylesheet" href="../Styles/mainPage.css">
    </head>
    <body>
        <div class="content">
            <div class="last-houses">
                <p class="last-houses-text">Last 5 Added Houses</p>
                <div class="house-cards">
                    <?php
                    // Fetch all homes
                    $result = getLastFiveHouses();
                    // Loop through the result set and include homecard.php
                    if ($result && $result->num_rows > 0) {
                        while ($house = $result->fetch_assoc()) {
                            displayHouseCard($house, 0);
                        }
                    } else {
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
