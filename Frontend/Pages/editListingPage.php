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
$houseInfo = null;
$houseID = 0;
if (isset($_GET['houseID']) && isset($_GET['city']) && isset($_GET['district']) && isset($_GET['neighborhood']) && isset($_GET['street'])) {
    $houseID = $_GET['houseID'];
    // Fetch house info from database using the house ID
    $houseInfo = getHouseInfoByIDFromDb($GLOBALS['conn'],$houseID); // Assuming this function exists to fetch the house info
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

    if ($houseInfo->id != 0) {
        editListing($houseInfo);  // Assuming this function exists to update the listing
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
        let selectedFiles = [];

        function previewFiles(event) {
            const fileInput = event.target;
            const filePreview = document.getElementById('filePreview');

            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];
                if (file.type.startsWith('image/')) {
                    selectedFiles.push(file);

                    const imgSrc = URL.createObjectURL(file);

                    const imageCard = document.createElement('div');
                    imageCard.className = 'image-card';

                    const img = document.createElement('img');
                    img.src = imgSrc;
                    img.className = 'image-preview';

                    imageCard.appendChild(img);

                    const closeButton = document.createElement('span');
                    closeButton.textContent = '×';
                    closeButton.className = 'close-button';
                    closeButton.onclick = function() {
                        removeImage(closeButton, file);
                    };

                    imageCard.appendChild(closeButton);
                    filePreview.appendChild(imageCard);
                }
            }
        }

        function removeImage(button, file) {
            const imageCard = button.parentElement;
            imageCard.remove();
            selectedFiles = selectedFiles.filter(f => f !== file);
        }

        function submitForm(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('createListingForm'));

            formData.delete('files[]');
            selectedFiles.forEach(file => {
                formData.append('files[]', file);
            });

            fetch('editListingPage.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    alert('The house info is updated!');
                    window.location.href = 'http://localhost:63342/vesthub-php/Frontend/Pages/myListingsPage.php'; //this is going to be adjusted on the server
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
                <input id="title" name="title" type="text" placeholder="Title" value="<?= isset($houseInfo) ? $houseInfo['title'] : '' ?>" style="width: 505px; height: 40px; border-radius: 10px" required>
            </div>
            <div class="input">
                <input id="description" name="description" type="text" placeholder="Description" value="<?= isset($houseInfo) ? $houseInfo['description'] : '' ?>" style="width: 505px; height: 110px; border-radius: 10px" required>
            </div>
            <div class="input">
                <select name="numOfRooms" id="numOfRooms" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 25px" required>
                    <option value="" selected hidden>Number of Rooms</option>
                    <?php foreach ($roomCount as $room): ?>
                        <option value="<?= $room ?>" <?= (isset($houseInfo) && htmlspecialchars($houseInfo['numOfRooms']) == $room) ? 'selected' : '' ?>><?= $room ?></option>
                    <?php endforeach; ?>
                </select>
                <input id="price" name="price" type="number" placeholder="Price" value="<?= isset($houseInfo) ? $houseInfo['price'] : '' ?>" style="width: 220px; height: 40px; border-radius: 10px" required>
            </div>
            <div class="input">
                <select id="city" name="city" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" onchange="updateDistricts()" required>
                    <option value="<?= isset($houseInfo['city']) ? htmlspecialchars($houseInfo['city']) : '' ?>" selected>
                        <?= isset($houseInfo['city']) ? htmlspecialchars($houseInfo['city']) : 'Select City' ?>
                    </option>
                </select>

                <select id="district" name="district" style="width: 220px; height: 40px; border-radius: 10px" onchange="updateNeighborhoods()" required>
                    <option value="<?= isset($houseInfo['district']) ? htmlspecialchars($houseInfo['district']) : '' ?>" selected>
                        <?= isset($houseInfo['district']) ? htmlspecialchars($houseInfo['district']) : 'Select District' ?>
                    </option>
                </select>
            </div>
            <div class="input">
                <select id="neighborhood" name="neighborhood" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" onchange="updateStreets()" required>
                    <option value=""><?= isset($houseInfo['neighborhood']) ? htmlspecialchars($houseInfo['neighborhood']) : 'Select neighborhood' ?></option>
                </select>
                <select id="street" name="street" style="width: 220px; height: 40px; border-radius: 10px" required>
                    <option value=""><?= isset($houseInfo['street']) ? htmlspecialchars($houseInfo['street']) : 'Select street' ?></option>
                </select>

            </div>

        </div>


        <div class="right">
            <?php displaySaleRentSwitchEdit($houseInfo);?>
            <div class="input">
                <select id="houseType" name="houseType" style="width: 280px; height: 40px; border-radius: 10px">
                    <option value="" selected hidden>House type</option>
                    <?php foreach ($houseType as $type) { ?>
                        <option value="<?= $type ?>" <?= (isset($houseInfo) && $houseInfo['houseType'] == $type) ? 'selected' : '' ?>> <?= $type ?> </option>
                    <?php } ?>
                </select>
            </div>

            <div class="input">
                <input type="number" name="floor" placeholder="Floor" value="<?= isset($houseInfo) ? $houseInfo['floor'] : '' ?>" style="width: 110px; height: 40px; border-radius: 10px; margin-right: 10px" required>
                <input type="number" name="totalFloor" placeholder="Total Floors" value="<?= isset($houseInfo) ? $houseInfo['totalFloor'] : '' ?>" style="width: 140px; height: 40px; border-radius: 10px" required>
            </div>
            <div class="input">
                <input type="number" name="area" placeholder="Area" style="width: 280px; height: 40px; border-radius: 10px; margin-bottom: 20px" required min="1" value="<?= isset($houseInfo) ? $houseInfo['area'] : '' ?>" required>
            </div>

            <div class="input">
                <label for="keyFeatures">Key Features:</label><br>
                <?php foreach ($keyFeatures as $feature): ?>
                    <?php
                    $featureInClass = str_replace(' ', '', $feature);
                    $featureInClass = lcfirst($featureInClass);
                    ?>
                    <input type="checkbox" name="keyFeatures[]" value="<?= $feature ?>" <?= isset($houseInfo) && $houseInfo[$featureInClass] == 1 ? 'checked' : '' ?>> <?= $feature ?><br>
                <?php endforeach; ?>
            </div>
            <button class="createListing" type="submit" id="submitBtn">Update Listing </button>
        </div>
    </form>
</div>
<script src="../../Backend/Scripts/addressFieldHandler.js"></script>
</body>
</html>
<?php include('../Components/footer.php'); ?>