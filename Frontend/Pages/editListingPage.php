<?php
require_once "../Components/imageBox.php";
include "../../Backend/editListingService.php";
require_once '../../Classes/houseInfo.php';
include '../Components/SaleRentSwitch.php';
use Classes\houseInfo;

// Define the room count, house type, and key features
$roomCount = ['1+0', '1+1', '2+0', '2+1', '3+1', '3+2', '4+1', '5+1', '6+1', '7+1'];
$houseType = ['Apartment', 'Villa', 'Studio'];
$keyFeatures = ['Fiber Internet', 'Air Conditioner', 'Floor Heating', 'Fireplace', 'Terrace', 'Satellite', 'Parquet', 'Steel Door', 'Furnished', 'Insulation'];

// Fetch house details if editing
$house = null;
$houseID = 0;
if (isset($_GET['houseID']) && isset($_GET['city']) && isset($_GET['district']) && isset($_GET['neighborhood']) && isset($_GET['street'])) {
    $houseID = $_GET['houseID'];
    $city = $_GET['city'];
    $district = $_GET['district'];
    $neighborhood = $_GET['neighborhood'];
    $street = $_GET['street'];
    // Fetch house info from database using the house ID
    $house = getHouseInfoByIDFromDb($GLOBALS['conn'],$houseID, $city, $district, $neighborhood, $street); // Assuming this function exists to fetch the house info
    if($house == null){
        return;
    }
}

// Handle form submission for creating or updating the listing
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
    $houseInfo->ownerID = (int)$_POST['ownerID'];
    $houseInfo->id = (int)$_POST['houseID'];

    $url = "https://geocode.maps.co/search?q=".rawurlencode($houseInfo->city).",".rawurlencode($houseInfo->district).",".rawurlencode($houseInfo->street)."&api_key=672e64f5dee6e743749773dwy569183";
    $response = file_get_contents($url);
    $decodedResponse = json_decode($response);
    if (!empty($decodedResponse) && isset($decodedResponse[0])) {
        echo $decodedResponse[0]->lat . "," . $decodedResponse[0]->lon;
        $houseInfo->lat = $decodedResponse[0]->lat;
        $houseInfo->lng = $decodedResponse[0]->lon;
    }

    $keptFiles = $_POST['keptFiles'];
    if ($houseInfo->id != 0) {
        editListing($houseInfo, $keptFiles);  // Assuming this function exists to update the listing
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing Page</title>
    <link rel="stylesheet" href="../Styles/newListingPage.css">
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="../Styles/imageBox.css">

    <script>
        function submitForm(event) {
            event.preventDefault();
            const floor = document.getElementById('floor').value;
            const totalFloor = document.getElementById('totalFloor').value;

            if (parseInt(floor) > parseInt(totalFloor)) {
                alert('The floor cannot be bigger than the total floor');
                return; // Prevent form submission
            }
            const formData = new FormData(document.getElementById('createListingForm'));

            formData.delete('files[]');
            selectedFiles.forEach(file => {
                formData.append('files[]', file);
            });

            const keptFiles = selectedFiles
                .filter(file => !file.isNew)
                .map(file => file.url); // URLs of existing files

            formData.append('keptFiles', JSON.stringify(keptFiles)); // Send existing kept files as JSON

            fetch('editListingPage.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    alert('The house info is updated!');
                    window.location.href = 'myListingsPage.php'; //this is going to be adjusted on the server
                } else {
                    alert('The house info is not updated! The update process is failed!');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</head>
<body>

<?php include('../Components/header.php'); ?>

<?php
$ownerID = 0;
if(isset($_SESSION['userID'])){
    $ownerID = $_SESSION['userID'];
}
?>

<div class="container">
    <form id="createListingForm" method="POST" action="editListingPage.php" class="form-section" enctype="multipart/form-data" onsubmit="submitForm(event)">
        <input type="hidden" name="ownerID" value="<?= $ownerID ?>">
        <input type="hidden" name="houseID" value="<?= $houseID ?>">

        <div class="left">
            <div class="upload-container">
                <label for="files">Select files to upload</label><br>
                <input type="file" accept="image/*" name="files[]" multiple onchange="previewFiles(event)"><br>

                <div id="filePreview"></div>
            </div>
        </div>

        <div class="middle">
            <div class="input">
                <input id="title" name="title" type="text" placeholder="Title" value="<?= isset($house) ? $house['title'] : '' ?>" style="width: 505px; height: 40px; border-radius: 10px" required>
            </div>
            <div class="input">
                <input id="description" name="description" type="text" placeholder="Description" value="<?= isset($house) ? $house['description'] : '' ?>" style="width: 505px; height: 110px; border-radius: 10px" required>
            </div>
            <div class="input">
                <select name="numOfRooms" id="numOfRooms" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 25px" required>
                    <option value="" selected hidden>Number of Rooms</option>
                    <?php foreach ($roomCount as $room): ?>
                        <option value="<?= $room ?>" <?= (isset($house) && htmlspecialchars($house['numOfRooms']) == $room) ? 'selected' : '' ?>><?= $room ?></option>
                    <?php endforeach; ?>
                </select>
                <input id="price" name="price" type="number" placeholder="Price" value="<?= isset($house) ? $house['price'] : '' ?>" style="width: 220px; height: 40px; border-radius: 10px" required>
            </div>
            <div class="input">
                <select id="city" name="city" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" onchange="updateDistricts()" required>
                    <option value="<?= isset($house['city']) ? htmlspecialchars($house['city']) : '' ?>" selected>
                        <?= isset($house['city']) ? htmlspecialchars($house['city']) : 'Select City' ?>
                    </option>
                </select>

                <select id="district" name="district" style="width: 220px; height: 40px; border-radius: 10px" onchange="updateNeighborhoods()" required>
                    <option value="<?= isset($house['district']) ? htmlspecialchars($house['district']) : '' ?>" selected>
                        <?= isset($house['district']) ? htmlspecialchars($house['district']) : 'Select District' ?>
                    </option>
                </select>
            </div>
            <div class="input">
                <select id="neighborhood" name="neighborhood" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" onchange="updateStreets()" required>
                    <option value=""><?= isset($house['neighborhood']) ? htmlspecialchars($house['neighborhood']) : 'Select neighborhood' ?></option>
                </select>
                <select id="street" name="street" style="width: 220px; height: 40px; border-radius: 10px" required>
                    <option value=""><?= isset($house['street']) ? htmlspecialchars($house['street']) : 'Select street' ?></option>
                </select>

            </div>

        </div>


        <div class="right">
            <?php displaySaleRentSwitchEdit($house);?>
            <div class="input">
                <select id="houseType" name="houseType" style="width: 280px; height: 40px; border-radius: 10px">
                    <option value="" selected hidden>House type</option>
                    <?php foreach ($houseType as $type) { ?>
                        <option value="<?= $type ?>" <?= (isset($house) && $house['houseType'] == $type) ? 'selected' : '' ?>> <?= $type ?> </option>
                    <?php } ?>
                </select>
            </div>

            <div class="input">
                <input type="number" id="floor" name="floor" placeholder="Floor" value="<?= isset($house) ? $house['floor'] : '' ?>" style="width: 110px; height: 40px; border-radius: 10px; margin-right: 10px" required>
                <input type="number" id ="totalFloor" name="totalFloor" placeholder="Total Floors" value="<?= isset($house) ? $house['totalFloor'] : '' ?>" style="width: 140px; height: 40px; border-radius: 10px" required>
            </div>
            <div class="input">
                <input type="number" id="area" name="area" placeholder="Area" value="<?= isset($house) ? $house['area'] : '' ?>" style="width: 280px; height: 40px; border-radius: 10px; margin-bottom: 20px" required min="1" required>
            </div>

            <div class="input">
                <label for="keyFeatures">Key Features:</label><br>
                <?php foreach ($keyFeatures as $feature): ?>
                    <?php
                    $featureInClass = str_replace(' ', '', $feature);
                    $featureInClass = lcfirst($featureInClass);
                    ?>
                    <input type="checkbox" name="keyFeatures[]" value="<?= $feature ?>" <?= isset($house) && $house[$featureInClass] == 1 ? 'checked' : '' ?>> <?= $feature ?><br>
                <?php endforeach; ?>
            </div>
            <button class="createListing" type="submit" id="submitBtn">Update Listing </button>
        </div>
    </form>
</div>
<script>
    const houseID = <?php echo $_GET['houseID'] ?>;
</script>
<script src="../../Backend/Scripts/addressFieldHandler.js"></script>
</body>
</html>
<?php include('../Components/footer.php'); ?>