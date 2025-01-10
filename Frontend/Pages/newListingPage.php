<?php
require_once "../Components/imageBox.php";
include "../../Backend/newListingService.php";
require_once '../../Classes/houseInfo.php';
include '../Components/SaleRentSwitch.php';
include('../Components/header.php');

use Classes\houseInfo;

if (!isset($_SESSION['userID']) || (isset($_SESSION['role']) && $_SESSION['role'] == 'admin')) {
    header("Location: loginPage.php");
}

$roomCount = ['1+0', '1+1', '2+0', '2+1', '3+1', '3+2', '4+1', '5+1', '6+1', '7+1'];
$houseType = ['Apartment', 'Villa', 'Studio'];
$keyFeatures = ['Fiber Internet', 'Air Conditioner', 'Floor Heating', 'Fireplace', 'Terrace',
    'Satellite', 'Parquet', 'Steel Door', 'Furnished', 'Insulation'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize houseInfo object
    $houseInfo = new HouseInfo($_POST);

    // Initialize feature variables with default values of 0
    $houseInfo->fiberInternet = 0;
    $houseInfo->airConditioner = 0;
    $houseInfo->floorHeating = 0;
    $houseInfo->fireplace = 0;
    $houseInfo->terrace = 0;
    $houseInfo->satellite = 0;
    $houseInfo->parquet = 0;
    $houseInfo->steelDoor = 0;
    $houseInfo->furnished = 0;
    $houseInfo->insulation = 0;
    $houseInfo->isSale = 1;
    $houseInfo->status = 'Pending';

    // Check if any key features were selected
    if (isset($_POST['keyFeatures'])) {
        // Iterate through the selected features and set their variables to 1
        foreach ($_POST['keyFeatures'] as $selectedFeature) {
            switch ($selectedFeature) {
                case 'Fiber Internet':
                    $houseInfo->fiberInternet = 1;
                    break;
                case 'Air Conditioner':
                    $houseInfo->airConditioner = 1;
                    break;
                case 'Floor Heating':
                    $houseInfo->floorHeating = 1;
                    break;
                case 'Fireplace':
                    $houseInfo->fireplace = 1;
                    break;
                case 'Terrace':
                    $houseInfo->terrace = 1;
                    break;
                case 'Satellite':
                    $houseInfo->satellite = 1;
                    break;
                case 'Parquet':
                    $houseInfo->parquet = 1;
                    break;
                case 'Steel Door':
                    $houseInfo->steelDoor = 1;
                    break;
                case 'Furnished':
                    $houseInfo->furnished = 1;
                    break;
                case 'Insulation':
                    $houseInfo->insulation = 1;
                    break;
            }
        }
    }

    if (isset($_POST['isSale'])) {
        $houseInfo->isSale = (int)$_POST['isSale']; // 0 Property is for rent
    }

    // Set the basic house information
    $houseInfo->title = mysqli_real_escape_string($GLOBALS['conn'], $_POST['title']);
    $houseInfo->description = mysqli_real_escape_string($GLOBALS['conn'], $_POST['description']);
    $houseInfo->numOfRooms = $_POST['numOfRooms'];
    $houseInfo->price = (int)$_POST['price'];
    $houseInfo->city = $_POST['city'];
    $houseInfo->district = $_POST['district'];
    $houseInfo->neighborhood = $_POST['neighborhood'];
    $houseInfo->street = $_POST['street'];
    $houseInfo->houseType = $_POST['houseType'];
    $houseInfo->floor = (int)$_POST['floor'];
    $houseInfo->totalFloor = (int)$_POST['totalFloor'];
    $houseInfo->area = (int)$_POST['area'];
    $houseInfo->ownerID = $_POST['ownerID'];
    $houseInfo->numOfBedroom = (int)$_POST['numOfBedroom'];
    $houseInfo->numOfBathroom = (int)$_POST['numOfBathroom'];

    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".rawurlencode($houseInfo->city).",".rawurlencode($houseInfo->district).",".rawurlencode($houseInfo->neighborhood).",".rawurlencode($houseInfo->street)."&key=AIzaSyCgUa6diztbBQ258McBxYPW6c4dCLYrjKc";
    $response = file_get_contents($url);
    $decodedResponse = json_decode($response);
    $houseInfo->lat = $decodedResponse->results[0]->geometry->location->lat;
    $houseInfo->lng = $decodedResponse->results[0]->geometry->location->lng;
    createListing($houseInfo);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Listing Page</title>
    <link rel="stylesheet" href="../Styles/newListingPage.css">
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="../Styles/imageBox.css">

    <script>

        function submitForm(event) {
            event.preventDefault(); // Prevent the default form submission
            const floor = document.getElementById('floor').value;
            const totalFloor = document.getElementById('totalFloor').value;
            const bedroom = document.getElementById('numOfBedroom').value;
            const rooms = document.getElementById('numOfRooms').value;
            console.log(bedroom, rooms)

            if (parseInt(floor) > parseInt(totalFloor)) {
                alert('The floor cannot be bigger than the total floor');
                return; // Prevent form submission
            }
            if(parseInt(bedroom) > parseInt(rooms.charAt(0))){
                alert('The number of bedroom cannot be bigger than the number of rooms');
                return; // Prevent form submission
            }
            const formData = new FormData(document.getElementById('createListingForm'));
            
            //replace files with the selected files
            formData.delete('files[]');

            // Append the selected files to the form data
            selectedFiles.forEach(file => {
                formData.append('files[]', file);
            });

            // Submit the form data using fetch or XMLHttpRequest
            fetch('newListingPage.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                // Handle the response
                if (response.ok) {
                    // Success
                    alert("House added successfully!");
                    window.location.href = 'myListingsPage.php'; //this is going to be adjusted on the server
                } else {
                    // Error
                    alert("House addition is failed!");
                    console.error('Form submission failed');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</head>
<body>

<?php
    $ownerID = 0;
    if(isset($_SESSION['userID'])){
        $ownerID = $_SESSION['userID'];
    }
?>
<div class="container"> <!-- Open: .container -->
        <form id="createListingForm" method="POST" action="newListingPage.php" class="form-section" enctype="multipart/form-data" onsubmit="submitForm(event)"> <!-- Open: form -->
            <input type="hidden" name="ownerID" value="<?= $ownerID ?>">
            <div class="left"> <!-- Open: .left -->
                <div class="upload-container"> <!-- Open: .upload-container -->
                    <label for="files">Select files to upload</label><br>
                    <input type="file" accept="image/*" name="files[]" multiple onchange="previewFiles(event)"><br>

                    <div id="filePreview"></div> <!-- Close: #filePreview -->
                </div> <!-- Close: .upload-container -->
            </div> <!-- Close: .left -->
            <div class="middle"> <!-- Open: .middle -->
                <div class="input">
                    <p> Title </p>
                    <input id="title" name="title" type="text" placeholder="Title" style="width: 505px; height: 40px; border-radius: 10px" required>
                </div>
                <div class="input">
                    <p> Description </p>
                    <input id="description" name="description" type="text" placeholder="Description" style="width: 505px; height: 110px; border-radius: 10px" required>
                </div>
                <div class="input-rows">
                    <div>
                        <p> Number of Bathroom</p>
                        <input id="numOfBathroom" name="numOfBathroom" type="number" placeholder="Number of bathroom" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 25px" required min="1">
                    </div>
                    <div>
                        <p> Number of Bedroom</p>
                        <input id="numOfBedroom" name="numOfBedroom" type="number" placeholder="Number of bedroom" style="width: 220px; height: 40px; border-radius: 10px" required min="1">
                    </div>
                </div>
                <div class="input-rows">
                    <div>
                    <p> Number of Rooms</p>
                    <select name="numOfRooms" id="numOfRooms" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 25px" required>
                        <option value="" selected hidden>Number of rooms</option>
                        <?php foreach ($roomCount as $room) { ?>
                            <option value="<?= $room ?>" ><?= $room ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    <div>
                        <p> Price</p>
                        <input id="price" name="price" type="number" placeholder="Price" style="width: 220px; height: 40px; border-radius: 10px" required min="0">
                    </div>
                </div>

                <div class="input-rows">
                    <div>
                        <p> City</p>
                        <select id="city" name="city" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" onchange="updateDistricts()" required>
                            <option value="">City</option>
                        </select>
                    </div>
                    <div>
                        <p> District</p>
                        <select id="district" name="district" style="width: 220px; height: 40px; border-radius: 10px" onchange="updateNeighborhoods()" required>
                            <option value="">District</option>
                        </select>
                    </div>
                </div>
                <div class="input-rows">
                    <div>
                        <p> Neighborhood</p>
                        <select id="neighborhood" name="neighborhood" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" onchange="updateStreets()" required>
                            <option value="">Neighborhood</option>
                        </select>
                    </div>
                    <div>
                        <p> Street</p>
                        <select id="street" name="street" style="width: 220px; height: 40px; border-radius: 10px" required>
                            <option value="">Street</option>
                        </select>
                    </div>
                </div>

            </div> <!-- Close: .middle -->

            <div class="right"> <!-- Open: .right -->
                <?php displaySaleRentSwitch();?>
                <div class="input">
                    <p> House Type</p>
                    <select id="houseType" name="houseType" style="width: 280px; height: 40px; border-radius: 10px">
                        <option value="" selected hidden>House type</option>
                        <?php foreach ($houseType as $type) { ?>
                            <option value="<?= $type ?>"> <?= $type ?> </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="input-rows">
                    <div>
                        <p> Floor </p>
                        <input id="floor" name="floor" type="number" placeholder="Floor" style="width: 110px; height: 40px; border-radius: 10px; margin-right: 10px" required min="-2">
                    </div>
                    <div>
                        <p> Total Floor </p>
                        <input id="totalFloor" name="totalFloor" type="number" placeholder="Total Floor" style="width: 140px; height: 40px; border-radius: 10px" required min="1">
                    </div>
                </div>

                <div class="input">
                    <p> Area</p>
                    <input id="area" name="area" type="number" placeholder="Area" style="width: 280px; height: 40px; border-radius: 10px; margin-bottom: 20px" required min="1">
                </div>

                <div class="input"> <!-- Open: .key-features -->
                 <label for="keyFeatures" style="display: block; margin-bottom: 8px">Features</label>
                    <div class="features-grid">
                        <?php foreach ($keyFeatures as $feature) { ?>
                                <label><input type="checkbox" name="keyFeatures[]" id="<?= $feature ?>" value="<?= $feature ?>"><?= $feature ?> </label>
                        <?php } ?>
                    </div> <!-- Close: .features-grid -->
                </div> <!-- Close: .key-features -->

                <button class="createListing" type="submit" id="submitBtn">Create Listing </button>
            </div> <!-- Close: .right -->
        </form> <!-- Close: form -->
</div> <!-- Close: .container -->
<script src="../../Backend/Scripts/addressFieldHandler.js"></script>
</body>
</html>
<?php include('../Components/footer.php'); ?> <!-- Footer kısmı dahil ediliyor -->