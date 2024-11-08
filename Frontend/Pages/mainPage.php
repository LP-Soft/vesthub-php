<?php
require '../Components/header.php';
include '../../Backend/mainPageService.php';
include '../Components/houseCard.php';
include '../Components/SaleRentSwitch.php';
session_start();

echo "<script>console.log('Debug Objects: " . $_SESSION['userID'] . "' );</script>";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Main Page</title>
    <link rel="stylesheet" href="../Styles/mainPage.css">
</head>

<body>
    <div class="content">
        <div class="search-area">
            <img src="../../house-images/dummy.png" alt="VestHub" class="background">
            <div class="search-box">
                <div class="welcome">
                    <p class="welcome-text">Welcome to VestHub</p>
                    <p class="welcome-slogan">The best place to find your dream home</p>
                </div>
                <div class="search-bar">
                    <form class="form" action="searchResultsPage.php" method="get" onsubmit="checkFields()">
                        <div class="display-sale-rent-switch">
                            <?php
                            displaySaleRentSwitch();
                            ?>
                        </div>
                        <div class="search-inputs">

                            <select class="search-select" name="city" id="city" onchange="updateDistricts()">
                                <option value="">City</option>
                                <!--Burası javascript ile dolduruluyor-->
                            </select>
                            <select class="search-select" name="district" id="district" onchange="updateNeighborhoods()">
                                <option value="">District</option>
                                <!--Burası javascript ile dolduruluyor-->
                            </select>
                            <select class="search-select" name="neighborhood" id="neighborhood">
                                <label for="neighborhood">Neighborhood</label>
                                <option value="">Neighborhood</option>
                                <!--Burası javascript ile dolduruluyor-->
                            </select>
                        </div>
                        <button class="search-button" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
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
    <script src="../../Backend/Scripts/addressFieldHandler.js"></script>
</body>

</html>

<?php
//closeConnection($conn);
include '../Components/footer.php';
?>