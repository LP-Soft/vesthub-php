<?php
require_once "../Components/imageBox.php";
include "../../Backend/newListingService.php";
require_once '../../Classes/houseInfo.php';
include '../Components/SaleRentSwitch.php';
use Classes\houseInfo;

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
    $houseInfo->title = $_POST['title'];
    $houseInfo->description = $_POST['description'];
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

    // Handle file uploads
    createListing($houseInfo);
}
?>

<!-- Sale/Rent button: https://codepen.io/alvarotrigo/pen/oNoJePo -->
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
        let selectedFiles = [];

        function previewFiles(event) {
            const fileInput = event.target; // Get the input element
            const filePreview = document.getElementById('filePreview');

            // Loop through the newly selected files
            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];

                // Only process image files
                if (file.type.startsWith('image/')) {
                    selectedFiles.push(file); // Add the file to the selectedFiles array

                    const imgSrc = URL.createObjectURL(file); // Create a temporary URL for the image

                    // Create a new image card using the PHP function
                    const imageCard = document.createElement('div');
                    imageCard.className = 'image-card';

                    // Create the image element
                    const img = document.createElement('img');
                    img.src = imgSrc;
                    img.className = 'image-preview';

                    // Add the image and close button to the image card
                    imageCard.appendChild(img);

                    const closeButton = document.createElement('span');
                    closeButton.textContent = '×'; // X symbol
                    closeButton.className = 'close-button';
                    closeButton.onclick = function() {
                        removeImage(closeButton, file);
                    };

                    // Append the close button to the image card
                    imageCard.appendChild(closeButton);

                    // Add the image card to the preview container
                    filePreview.appendChild(imageCard);
                }
            }
        }

        function removeImage(button, file) {
            const imageCard = button.parentElement; // Get the image card (parent of the button)
            imageCard.remove(); // Remove the image card from the preview

            // Remove the file from the selectedFiles array
            selectedFiles = selectedFiles.filter(f => f !== file);
        }

        function submitForm(event) {
            event.preventDefault(); // Prevent the default form submission

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
                    console.log('Form submitted successfully');
                } else {
                    // Error
                    console.error('Form submission failed');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</head>
<body>

<?php include('../Components/header.php'); ?>
<div class="container"> <!-- Open: .container -->
        <form id="createListingForm" method="POST" action="newListingPage.php" class="form-section" enctype="multipart/form-data" onsubmit="submitForm(event)"> <!-- Open: form -->
            <div class="left"> <!-- Open: .left -->
                <div class="upload-container"> <!-- Open: .upload-container -->
                    <label for="files">Select files to upload</label><br>
                    <input type="file" accept="image/*" name="files[]" multiple onchange="previewFiles(event)"><br>

                    <div id="filePreview"></div> <!-- Close: #filePreview -->
                </div> <!-- Close: .upload-container -->
            </div> <!-- Close: .left -->
            <div class="middle"> <!-- Open: .middle -->
                <div class="input">
                    <input id="title" name="title" type="text" placeholder="Title" style="width: 505px; height: 40px; border-radius: 10px" required>
                </div>
                <div class="input">
                    <input id="description" name="description" type="text" placeholder="Description" style="width: 505px; height: 110px; border-radius: 10px" required>
                </div>
                <div class="input">
                    <select name="numOfRooms" id="numOfRooms" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 25px" required>
                        <option value="" selected hidden>Number of rooms</option>
                        <?php foreach ($roomCount as $room) { ?>
                            <option value="<?= $room ?>" ><?= $room ?></option>
                        <?php } ?>
                    </select>
                    <input id="price" name="price" type="number" placeholder="Price" style="width: 220px; height: 40px; border-radius: 10px" required min="0">
                </div>
                <div class="input">
                    <select id="city" name="city" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" onchange="updateDistricts()" required>
                        <option value="">City</option>
                    </select>
                    <select id="district" name="district" style="width: 220px; height: 40px; border-radius: 10px" onchange="updateNeighborhoods()" required>
                        <option value="">District</option>
                    </select>
                </div>
                <div class="input">
                    <select id="neighborhood" name="neighborhood" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" onchange="updateStreets()" required>
                        <option value="">Neighborhood</option>
                    </select>
                    <select id="street" name="street" style="width: 220px; height: 40px; border-radius: 10px" required>
                        <option value="">Street</option>
                    </select>

                </div>

            </div> <!-- Close: .middle -->

            <div class="right"> <!-- Open: .right -->
                <?php displaySaleRentSwitch();?>
                <div class="input">
                    <select id="houseType" name="houseType" style="width: 280px; height: 40px; border-radius: 10px">
                        <option value="" selected hidden>House type</option>
                        <?php foreach ($houseType as $type) { ?>
                            <option value="<?= $type ?>"> <?= $type ?> </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="input">
                    <input id="floor" name="floor" type="number" placeholder="Floor" style="width: 110px; height: 40px; border-radius: 10px; margin-right: 10px" required min="-2">
                    <input id="totalFloor" name="totalFloor" type="number" placeholder="Total Floor" style="width: 140px; height: 40px; border-radius: 10px" required min="1">
                </div>

                <div class="input">
                    <input id="area" name="area" type="number" placeholder="Area" style="width: 280px; height: 40px; border-radius: 10px; margin-bottom: 20px" required min="1">
                </div>

                <div class="input"> <!-- Open: .key-features -->
                    <label for="keyFeatures">Features</label>
                    <div class="features-grid">
                        <?php $counter = 0 ?>
                        <?php foreach ($keyFeatures as $feature) { ?>
                                <?php $counter++ ?>
                                <input type="checkbox" name="keyFeatures[]" id="<?= $feature ?>" value="<?= $feature ?>">
                                <label for="<?= $feature ?>"><?= $feature ?> </label>
                                <?php if ($counter%2 == 0) { echo "<br>"; }?>

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