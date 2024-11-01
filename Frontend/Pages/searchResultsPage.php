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
<?php include('../Components/header.php'); ?> <!-- Header included -->
<div class="Content">
    <?php
    echo "<h1>Search Results : </h1>";
    ?>
    <div class="FilterContent">
        <div class="FilterBar">
            <form>
                <label for="city">City:</label>
                <select name="city" id="city" onchange="this.form.submit()">
                <option value="">Select City</option>
                <?php
                    $Allcitys = getCity();
                    if (!empty($Allcitys)) {
                        foreach ($Allcitys as $City) {
                            $selected = (isset($_GET['city']) && $_GET['city'] == $City) ? "selected" : "";
                            echo "<option value='$City'>$City</option>";
                            
                        }
                    } else {
                        echo "<option value=''>No cities found</option>";
                    }
                ?>
                </select><label for="district">District:</label>
                <select name="district" id="district" onchange="this.form.submit()">
                    <option value="">Select district</option>
                    <?php
                        if (isset($_GET['city'])) {
                            $city = $_GET['city'];
                            $districts = getDistrictsByCity($city);
                            
                            if (!empty($districts)) {
                                foreach ($districts as $district) {
                                    echo "<option value='$district'>$district</option>";
                                }
                            } else {
                                echo "<option value=''>No districts found</option>";
                            }
                        }
                    ?>
                </select>
                <label for="neighborhood">Neighborhood:</label>
                <select name="neighborhood" id="neighborhood"onchange="this.form.submit()">
                    <option value="">Select neighborhood</option>
                    <?php
                        if (isset($_GET['district'])) {
                            $district = $_GET['district'];
                            $neighborhoods = getNeighboorhoodByDistrict($district);
                            
                            if (!empty($neighborhoods)) {
                                foreach ($neighborhoods as $neighborhood) {
                                    echo "<option value='$neighborhood'>$neighborhood</option>";
                                }
                            } else {
                                echo "<option value=''>No neighborhoods found</option>";
                            }
                        }
                    ?>
                </select>    
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="SearchContent">
    <?php
        $SeachResults = getAllHouses();
        if($SeachResults) {
            while ($house = $SeachResults->fetch_assoc()) {
                displayHouseCard($house, 0);
            }
        } else {
            echo "<p>No pending houses found.</p>";
        }
        ?>
    </div>    
</div>