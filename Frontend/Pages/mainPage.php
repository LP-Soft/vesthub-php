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
        <div class="search-area">
            <img src="../../house-images/dummy.png" alt="VestHub Logo" class="logo">
            <div class="search-box">
                <div class="welcome">
                    <p class="welcome-text">Welcome to VestHub</p>
                    <p class="welcome-slogan">The best place to find your dream home</p>
                </div>
                <div class="search-bar">
                    <form action="searchPage.php" method="get">
                        <div class="search-inputs">
                            <select name="city" id="city">
                                <option value="Ankara">Ankara</option>
                                <option value="Istanbul">Istanbul</option>
                                <option value="Izmir">Izmir</option>
                                <option value="Antalya">Antalya</option>
                            </select>
                            <select name="district" id="district">
                                <option value="Cankaya">Cankaya</option>
                                <option value="Kecioren">Kecioren</option>
                                <option value="Mamak">Mamak</option>
                                <option value="Yenimahalle">Yenimahalle</option>
                            </select>
                            <select name="neighborhood" id="neighborhood">
                                <option value="Bahcelievler">Bahcelievler</option>
                                <option value="Kizilay">Kizilay</option>
                                <option value="Maltepe">Maltepe</option>
                                <option value="Tandogan">Tandogan</option>
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
</body>

</html>

<?php
//closeConnection($conn);
include '../Components/footer.php';
?>