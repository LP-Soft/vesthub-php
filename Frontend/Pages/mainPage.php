<?php
require '../Components/header.php';
include '../../Backend/mainPageService.php';
include '../Components/houseCard.php';
include '../Components/saleRentSwitch.php';
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
                    <form action="searchResultsPage.php" method="get" onsubmit="checkFields()">
                        <div class="display-sale-rent-switch">
                            <?php
                            displaySaleRentSwitch();
                            ?>
                        </div>
                        <div class="search-inputs">

                            <select class="search-select" name="city" id="city" onchange="updateDistricts()">
                                <option value="">City</option>
                                <?php
                                $cities = getCities();
                                while ($city = $cities->fetch_assoc()) {
                                    echo "<option value=" . $city['city'] . ">" . $city['city'] . "</option>";
                                }
                                ?>
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
        // city-district[] ve district-neighborhood[] olarak verileri tutuyoruz
        // örnek Antalya : ['Kepez', 'Finike', 'Muratpaşa']
        // Kepez : ['3718. Sokak']

        // php ile alınan verileri javascript tarafında kullanabilmek için json formatına çeviriyoruz
        var cityDistrictPairs = <?php echo json_encode(getCityDistrictPairs()); ?>;
        var districtNeighborhoodPairs = <?php echo json_encode(getDistrictNeighborhoodPairs()); ?>;
        console.log(cityDistrictPairs);
        console.log(districtNeighborhoodPairs);

        function updateDistricts() {
            const citySelect = document.getElementById("city");
            const districtSelect = document.getElementById("district");
            const selectedCity = citySelect.value;

            // önce district seçeneklerini temizle
            districtSelect.innerHTML = '<option value="">District</option>';

            // Seçilen citye ait districtleri ekle
            cityDistrictPairs[selectedCity].forEach((district) => {
                let option = document.createElement("option"); // yeni bir option elementi oluştur  
                option.value = district; // option elementinin value değerini ata
                option.text = district; // option elementinin text değerini ata
                districtSelect.appendChild(option); // districtSelect elementine option elementini ekle
            });

            // neighborhood seçeneklerini temizle
            document.getElementById("neighborhood").innerHTML = '<option value="">Neighborhood</option>';
        }

        function updateNeighborhoods() {
            const districtSelect = document.getElementById("district");
            const neighborhoodSelect = document.getElementById("neighborhood");
            const selectedDistrict = districtSelect.value;

            neighborhoodSelect.innerHTML = '<option value="">Neighborhood</option>';

            districtNeighborhoodPairs[selectedDistrict].forEach((neighborhood) => {
                let option = document.createElement("option");
                option.value = neighborhood;
                option.text = neighborhood;
                neighborhoodSelect.appendChild(option);
            });
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