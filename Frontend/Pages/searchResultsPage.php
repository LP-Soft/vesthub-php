<?php
   include '../../Backend/searchResultsService.php';
   include '../Components/houseCard.php';
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>
   <link rel="stylesheet" href="../Styles/searchResults.css">
   <link rel="stylesheet" href="../Styles/styles.css">
   <link rel="stylesheet" href="../Styles/houseCard.css">
</head>
<body>
<?php include('../Components/header.php'); 
$filters = [
    'sale_rent' => $_GET['sale_rent'] ?? null,
    'city' => $_GET['city'] ?? null,
    'district' => $_GET['district'] ?? null,
    'neighborhood' => $_GET['neighborhood'] ?? null,
    'house_type' => $_GET['house_type'] ?? null,
    'sort' => $_GET['sort'] ?? null,
];
if (isset($_GET['amenities'])) {
    $filters['amenities'] = $_GET['amenities'];
}
if (isset($_GET['sort'])) {
    $filters['sort'] = $_GET['sort'];
}
$searchResults = getFilteredHouses($filters);
?>
 <!-- Header included -->

<div class="MainContainer">
   <div class="Sidebar">
      <h2>Filters</h2>
      <form>
         <label for="sale_rent">Type:</label>
         <select name="sale_rent" id="sale_rent">
            <option value="">Rent / Sale</option>
            <option value="rent">Rent</option>
            <option value="sale">Sale</option>
         </select>
         <label for="city">City:</label>
         <select name="city" id="city" onchange="updateDistricts()">
            <option value="">Select City</option>
            <?php
               $cities = getCity();
               foreach ($cities as $city) {
                  $selected = (isset($_GET['city']) && $_GET['city'] == $city) ? "selected" : "";
                  echo "<option value='$city' $selected>$city</option>";
               }
            ?>
         </select>
         <label for="district">District:</label>
         <select name="district" id="district" onchange="updateNeighborhoods()">
            <option value="">Select District</option>
         </select>
         <label for="neighborhood">Neighborhood:</label>
         <select name="neighborhood" id="neighborhood">
            <option value="">Select Neighborhood</option>
         </select>
         <label for="sort">Sort By:</label>
         <select name="sort" id="sort">
            <option value="">Sort</option>
            <option value="price_asc">Price - Low to High</option>
            <option value="price_desc">Price - High to Low</option>
            <option value="size_asc">Size - Small to Large</option>
            <option value="size_desc">Size - Large to Small</option>
         </select>
         <label for="house_type">House Type:</label>
         <select name="house_type" id="house_type">
            <option value="">Select Type</option>
            <option value="apartment">Apartment</option>
            <option value="villa">Villa</option>
            <option value="detached">Detached House</option>
         </select>
         <label for="amenities">Amenities:</label>
         <div class="Amenities">
            <label><input type="checkbox" name="amenities[]" value="pool"> Pool</label>
            <label><input type="checkbox" name="amenities[]" value="gym"> Gym</label>
            <label><input type="checkbox" name="amenities[]" value="parking"> Parking</label>
            <label><input type="checkbox" name="amenities[]" value="garden"> Garden</label>
         </div>
         <button type="submit">Apply Filters</button>
      </form>
   </div>
   <div class="Content">
      <?php echo "<h1>Search Results :</h1>"; ?>
      <div class="SearchContent">
        <?php
        if($searchResults) {
            while ($house = $searchResults->fetch_assoc()) {
                displayHouseCard($house, 0);
            }
        } else {
            echo "<p>No houses found for the selected filters.</p>";
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
    </script>
</body>
</html>