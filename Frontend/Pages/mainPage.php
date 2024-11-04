<?php
require '../Components/header.php';
include '../../Backend/mainPageService.php';
include '../Components/houseCard.php';
include '../Components/SaleRentSwitch.php';
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
                    <form class="form" action="searchResultsPage.php" method="get">
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {fetch("../../Backend/Utilities/getCities.php")
            .then(response => response.json())
            .then(data => {
                const citySelect = document.getElementById("city");
                citySelect.innerHTML = '<option value="">City</option>';
                data.forEach(city => {
                    let option = document.createElement("option");
                    option.value = city;
                    option.text = city;
                    citySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
        });

        function updateDistricts() {
            const citySelect = document.getElementById("city");
            const districtSelect = document.getElementById("district");
            const selectedCity = citySelect.value;

            if (selectedCity) {
                fetch(`../../Backend/Utilities/getDistricts.php?city=${selectedCity}`)
                    .then(response => response.json())
                    .then(data => {
                        districtSelect.innerHTML = '<option value="">District</option>';
                        data.forEach(district => {
                            let option = document.createElement("option");
                            option.value = district;
                            option.text = district;
                            districtSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching districts:', error));
            } else {
                districtSelect.innerHTML = '<option value="">District</option>';
            }
            // delete all neighborhoods
            document.getElementById("neighborhood").innerHTML = '<option value="">Neighborhood</option>';
        }

        function updateNeighborhoods() {
            const districtSelect = document.getElementById("district");
            const neighborhoodSelect = document.getElementById("neighborhood");
            const selectedDistrict = districtSelect.value;

            if (selectedDistrict) {
                fetch(`../../Backend/Utilities/getNeighborhoods.php?district=${selectedDistrict}`)
                    .then(response => response.json())
                    .then(data => {
                        neighborhoodSelect.innerHTML = '<option value="">Neighborhood</option>';
                        data.forEach(neighborhood => {
                            let option = document.createElement("option");
                            option.value = neighborhood;
                            option.text = neighborhood;
                            neighborhoodSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching neighborhoods:', error));
            } else {
                neighborhoodSelect.innerHTML = '<option value="">Neighborhood</option>';
            }
        }

        function checkFields() {
            const city = document.getElementById("city").value;
            const district = document.getElementById("district").value;
            const neighborhood = document.getElementById("neighborhood").value;

            if (city === "" || district === "" || neighborhood === "") {
                alert("Please fill all fields.");
                event.preventDefault();
            }
        }
    </script>
</body>

</html>

<?php
//closeConnection($conn);
include '../Components/footer.php';
?>