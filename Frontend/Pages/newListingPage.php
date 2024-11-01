<?php
include "../Components/imageBox.php";
$roomCount = ['1+0', '1+1', '2+0', '2+1', '3+1', '3+2', '4+1', '5+1', '6+1', '7+1'];
$houseType = ['Apartment', 'Villa', 'Studio'];
$keyFeatures = ['Fiber Internet', 'Air Conditioner', 'Floor Heating', 'Fireplace', 'Terrace',
    'Satellite', 'Parquet', 'Steel Door', 'Furnished', 'Insulation'];
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
        function previewFiles(event) {
            const fileInput = event.target; // Get the input element
            const filePreview = document.getElementById('filePreview');

            // Loop through the newly selected files
            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];

                // Only process image files
                if (file.type.startsWith('image/')) {
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
                        removeImage(closeButton); // Remove the image on click
                    };

                    // Append the close button to the image card
                    imageCard.appendChild(closeButton);

                    // Add the image card to the preview container
                    filePreview.appendChild(imageCard);
                }
            }
        }

        function removeImage(button) {
            const imageCard = button.parentElement; // Get the image card (parent of the button)
            imageCard.remove(); // Remove the image card from the preview
        }
    </script>
</head>
<body>

<?php include('../Components/header.php'); ?>
<div class="container"> <!-- Open: .container -->
        <form id="createListingForm" method="POST" action="../../Backend/newListingService.php" class="form-section" enctype="multipart/form-data"> <!-- Open: form -->
            <div class="left"> <!-- Open: .left -->
                <div class="upload-container"> <!-- Open: .upload-container -->
                    <label for="files">Select files to upload</label><br>
                    <input type="file" name="files[]" multiple onchange="previewFiles(event)"><br>

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
                            <option value="<?= $room ?>"><?= $room ?></option>
                        <?php } ?>
                    </select>
                    <input id="price" name="price" type="number" placeholder="Price" style="width: 220px; height: 40px; border-radius: 10px" required>
                </div>
                <div class="input">
                    <input id="city" name="city" type="text" placeholder="City" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" required>
                    <input id="district" name="district" type="text" placeholder="District" style="width: 220px; height: 40px; border-radius: 10px" required>
                </div>
                <div class="input">
                    <input id="neighborhood" name="neighborhood" type="text" placeholder="Neighborhood" style="width: 250px; height: 40px; border-radius: 10px; margin-right: 20px" required>
                    <input id="street" name="street" type="text" placeholder="Street" style="width: 220px; height: 40px; border-radius: 10px" required>
                </div>

            </div> <!-- Close: .middle -->

            <div class="right"> <!-- Open: .right -->
                <div class="toggle-button-cover">
                    <div class="button b2" id="isSale">
                        <input type="checkbox" name="isSale" id="isSale" class="checkbox" value=""/>
                        <div class="knobs">
                            <span></span>
                        </div>
                        <div class="layer"></div>
                    </div>
                </div>

                <div class="input">
                    <select id="houseType" name="houseType" style="width: 280px; height: 40px; border-radius: 10px">
                        <option value="" selected hidden>House type</option>
                        <?php foreach ($houseType as $type) { ?>
                            <option value="<?= $type ?>"><?= $type ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="input">
                    <input id="floor" name="floor" type="number" placeholder="Floor" style="width: 110px; height: 40px; border-radius: 10px; margin-right: 10px" required min="-2">
                    <input id="totalFloor" name="totalFloor" type="number" placeholder="Total Floor" style="width: 140px; height: 40px; border-radius: 10px" required min="0">
                </div>

                <div class="input">
                    <input id="area" name="area" type="number" placeholder="Area" style="width: 280px; height: 40px; border-radius: 10px; margin-bottom: 20px" required min="0">
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

<?php include('../Components/footer.php'); ?> <!-- Footer kısmı dahil ediliyor -->
</body>
</html>