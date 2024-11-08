<?php
require_once '../Components/header.php';
require_once '../../Backend/houseDetailsService.php';
require_once '../../Backend/Utilities/getUserInfo.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the house ID from the URL parameter (or set to 1 for testing)
$houseId = 1;  // Replace this with dynamic ID if needed (e.g., $_GET['id'])

// Function to get house images dynamically from the directory
function getHouseImages($houseId) {
    $directory = "../../house-images/{$houseId}/"; // Set the directory path based on the house ID
    $images = glob($directory . "*.{jpg,png,gif}", GLOB_BRACE); // Get all image files in the directory
    return $images ?: []; // Return images if found, else an empty array
}

// Fetch images for the specific house
$houseImages = getHouseImages($houseId);

// Get house details from the backend (use the function defined in houseDetailsService.php)
$house = getHouseDetails($houseId); // Fetch the house details as an object
$user = getUserInfo(2); // Fetch the user details as an object
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Details</title>
    <link rel="stylesheet" href="../Styles/houseDetailsPage.css">
</head>
<body>
<div class="content">
    <div class="house-details-container">
        <!-- Image Column -->
        <div class="image-column">
            <div class="main-image">
                <img id="mainHouseImage" src="<?php echo htmlspecialchars($houseImages[0] ?? '../../house-images/default.png'); ?>" alt="House Front View">
                <div class="image-navigation">
                    <button class="nav-button-prev">❮</button>
                    <button class="nav-button-next">❯</button>
                </div>
            </div>
            <!-- Thumbnail Container -->
            <div class="thumbnail-container">
                <?php foreach ($houseImages as $index => $image): ?>
                    <img class="thumbnail" src="<?php echo htmlspecialchars($image); ?>"
                         alt="House View <?php echo $index + 1; ?>"
                         onclick="changeImage(<?php echo $index; ?>)">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Middle Column - House Details -->
        <div class="details-column">
            <h1 class="house-title"><?php echo htmlspecialchars($house->title); ?></h1>
            <div class="location">
                <span><?php echo htmlspecialchars($house->city); ?></span>
                <span><?php echo htmlspecialchars($house->district); ?></span>
                <span><?php echo htmlspecialchars($house->street); ?></span>
                <span><?php echo htmlspecialchars($house->neighborhood); ?></span>
            </div>

            <div class="house-info">
                <div class="info-item">
                    <span class="label">House Type:</span>
                    <span class="value"><?php echo htmlspecialchars($house->houseType); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Number of rooms:</span>
                    <span class="value"><?php echo htmlspecialchars($house->numOfRooms); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Area:</span>
                    <span class="value"><?php echo htmlspecialchars($house->area); ?> m²</span>
                </div>
                <div class="info-item">
                    <span class="label">Floor:</span>
                    <span class="value"><?php echo htmlspecialchars($house->floor); ?>, Total Floor: <?php echo htmlspecialchars($house->totalFloor); ?></span>
                </div>
            </div>

            <div class="features">
                <h2>Features</h2>
                <div class="features-grid">
                    <div class="feature"><?php echo $house->satellite ? '✓ Satellite' : '✘ Satellite'; ?></div>
                    <div class="feature"><?php echo $house->airConditioner ? '✓ Air Conditioner' : '✘ Air Conditioner'; ?></div>
                    <div class="feature"><?php echo $house->floorHeating ? '✓ Floor Heating' : '✘ Floor Heating'; ?></div>
                    <div class="feature"><?php echo $house->fireplace ? '✓ Fireplace' : '✘ Fireplace'; ?></div>
                    <div class="feature"><?php echo $house->terrace ? '✓ Terrace' : '✘ Terrace'; ?></div>
                    <div class="feature"><?php echo $house->insulation ? '✓ Insulation' : '✘ Insulation'; ?></div>
                    <div class="feature"><?php echo $house->parquet ? '✓ Parquet' : '✘ Parquet'; ?></div>
                    <div class="feature"><?php echo $house->steelDoor ? '✓ Steel Door' : '✘ Steel Door'; ?></div>
                    <div class="feature"><?php echo $house->furnished ? '✓ Furnished' : '✘ Furnished'; ?></div>
                    <div class="feature"><?php echo $house->fiberInternet ? '✓ Fiber Internet' : '✘ Fiber Internet'; ?></div>
                </div>
            </div>

            <div class="description">
                <h2>Description</h2>
                <p><?php echo htmlspecialchars($house->description); ?></p>
            </div>
        </div>

        <!-- Right Column - Price and Contact -->
        <div class="contact-column">
            <div class="price"><?php echo number_format($house->price, 0, '.', ','); ?>₺ <span class="for-sale-badge"><?php echo $house->isSale ? 'For Sale' : 'For Rent'; ?></span></div>
            <div class="contact-info">
                <p>Contact: Ali Taş</p>
                <p class="phone">📞 +90 555 55 55 55</p>
            </div>
            <div class="map-container">
                <iframe
                        src="https://maps.google.com/maps?q=<?php echo $house->lat; ?>,<?php echo $house->lng; ?>&hl=en&z=14&amp;output=embed&markers=<?php echo $house->lat; ?>,<?php echo $house->lng; ?>"
                        width="100%"
                        height="300"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Image Navigation -->
<script>
    const houseImages = <?php echo json_encode($houseImages); ?>;
    let currentImageIndex = 0;

    const mainImage = document.getElementById('mainHouseImage');
    const prevButton = document.querySelector('.nav-button-prev');
    const nextButton = document.querySelector('.nav-button-next');
    const thumbnails = document.querySelectorAll('.thumbnail');

    function updateImage(index) {
        if (index < 0) index = houseImages.length - 1;
        if (index >= houseImages.length) index = 0;

        currentImageIndex = index;
        mainImage.src = houseImages[currentImageIndex];

        // Update active thumbnail
        thumbnails.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === currentImageIndex);
        });
    }

    function changeImage(index) {
        updateImage(index);
    }

    // Event listeners for navigation buttons
    prevButton.addEventListener('click', () => {
        updateImage(currentImageIndex - 1);
    });
    nextButton.addEventListener('click', () => {
        updateImage(currentImageIndex + 1);
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            updateImage(currentImageIndex - 1);
        } else if (e.key === 'ArrowRight') {
            updateImage(currentImageIndex + 1);
        }
    });

    // Initialize with the first image
    updateImage(0);
</script>

</body>
</html>

<?php
include '../Components/footer.php';
?>
