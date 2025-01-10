<?php
   include '../../Backend/searchResultsService.php';
   include '../Components/houseCard.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Results</title>
   <link rel="stylesheet" href="../Styles/searchResults.css">
   <link rel="stylesheet" href="../Styles/styles.css">
   <link rel="stylesheet" href="../Styles/houseCard.css">
</head>
<body>
<?php include('../Components/header.php'); 
$filters = [
    'isSale' => $_GET['isSale'] ?? null,
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

<div class="MainContainer">
   <div class="Sidebar">
      <h2>Filters</h2>
      <form>
         <label for="isSale">Type:</label>
         <select name="isSale" id="isSale">
            <option value="0">Rent</option>
            <option value="1">Sale</option>
         </select>
         <label for="city">City:</label>
         <select name="city" id="city" onchange="updateDistricts()">
            <option value="">Select City</option>
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
         </select>
         <label for="house_type">House Type:</label>
         <select name="house_type" id="house_type">
            <option value="">Select Type</option>
            <option value="apartment">Apartment</option>
            <option value="villa">Villa</option>
            <option value="studio">Studio</option>
         </select>
         <label for="amenities">Amenities:</label>
         <div class="Amenities">
            <label><input type="checkbox" name="amenities[]" value="floorHeating"> Floor Heating</label>
            <label><input type="checkbox" name="amenities[]" value="terrace"> Terrace </label>
            <label><input type="checkbox" name="amenities[]" value="Parquet"> Parquet</label>
            <label><input type="checkbox" name="amenities[]" value="furnished"> Furnished</label>
            <label><input type="checkbox" name="amenities[]" value="fiberInternet"> Fiber Internet</label>
            <label><input type="checkbox" name="amenities[]" value="airConditioner"> Air Conditioner</label>
            <label><input type="checkbox" name="amenities[]" value="fireplace"> Fireplace</label>
            <label><input type="checkbox" name="amenities[]" value="satellite"> Satellite</label>
            <label><input type="checkbox" name="amenities[]" value="steelDoor"> Steel Door</label>
            <label><input type="checkbox" name="amenities[]" value="insulation"> Insulation</label>
         </div>
         <button type="submit">Apply Filters</button>
      </form>
   </div>
   <div class="Content">
      <?php echo "<h1>Search Results :</h1>"; ?>
      <div class="SearchContent">
        <?php
        if($searchResults && $searchResults->num_rows > 0) {
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
<script src="../../Backend/Scripts/addressFieldHandler.js"></script>
</body>
</html>
<?php
include '../Components/footer.php';
?>