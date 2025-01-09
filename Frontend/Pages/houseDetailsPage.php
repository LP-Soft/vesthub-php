<?php
require_once '../Components/header.php';
require_once '../../Backend/houseDetailsService.php';
require_once '../../Backend/Utilities/getUserInfo.php';
require_once '../../Backend/favoritesService.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$houseId = $_GET['id'];

$dummyImageArray = array("../../house-images/dummy.png");

$userLogged = -1;
if (isset($_SESSION['userID']))
{
    $userLogged = $_SESSION['userID'];
}
function getHouseImages($houseId)
{
    $directory = "../../house-images/{$houseId}/";
    $images = glob($directory . "*.{jpg,png,gif}", GLOB_BRACE);
    return $images ?: [];
}

// Fetch images for the specific house
$houseImages = getHouseImages($houseId);

$house = getHouseDetails($houseId);
$owner = getUserInfo($house->ownerID);

$result = getFavoriteHousesByOwner($userLogged);
$favorites = [];

if ($result && $result->num_rows > 0) {
    while ($favHouse = $result->fetch_assoc()) {
        $favorites[] = $favHouse['houseID'];
    }
}

//echo "favorites: " . $favorites[2];
//echo "house: " . json_encode($house->houseID);
//echo "house images: " . json_encode($houseImages);
//echo "dummy image array: " . json_encode($dummyImageArray);

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
                <img id="mainHouseImage"
                     src=""
                     alt="House Front View"/>
                <div class="image-navigation">
                    <button class="nav-button-prev">❮</button>
                    <button class="nav-button-next">❯</button>
                </div>
            </div>
            <!-- Thumbnail Container -->
            <div class="thumbnail-container">
                <?php
                if ($houseImages == null) {
                    $houseImages = $dummyImageArray;
                }
                foreach ($houseImages as $index => $image): ?>
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
                <span><?php echo htmlspecialchars($house->neighborhood); ?></span>
                <span><?php echo htmlspecialchars($house->street); ?></span>
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
                    <span class="label">Floor/Total Floor:</span>
                    <span class="value"><?php echo htmlspecialchars($house->floor); ?>/<?php echo htmlspecialchars($house->totalFloor); ?></span>
                </div>
            </div>

            <div class="features">
                <h2>Features</h2>
                <div class="features-grid">
                    <div class="feature <?php echo $house->satellite ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->satellite ? 'available' : 'not-available'; ?>"><?php echo $house->satellite ? '✓' : '✘'; ?></p>
                        <p><?php echo ' Satellite'; ?></p>
                    </div>
                    <div class="feature <?php echo $house->airConditioner ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->airConditioner ? 'available' : 'not-available'; ?>"><?php echo $house->airConditioner ? '✓' : '✘'; ?></p>
                        <?php echo $house->airConditioner ? ' Air Conditioner' : ' Air Conditioner'; ?>
                    </div>
                    <div class="feature <?php echo $house->floorHeating ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->floorHeating ? 'available' : 'not-available'; ?>"><?php echo $house->floorHeating ? '✓' : '✘'; ?></p>
                        <?php echo $house->floorHeating ? ' Floor Heating' : ' Floor Heating'; ?>
                    </div>
                    <div class="feature <?php echo $house->fireplace ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->fireplace ? 'available' : 'not-available'; ?>"><?php echo $house->fireplace ? '✓' : '✘'; ?></p>
                        <?php echo $house->fireplace ? ' Fireplace' : ' Fireplace'; ?>
                    </div>
                    <div class="feature <?php echo $house->terrace ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->terrace ? 'available' : 'not-available'; ?>"><?php echo $house->terrace ? '✓' : '✘'; ?></p>
                        <?php echo $house->terrace ? ' Terrace' : ' Terrace'; ?>
                    </div>
                    <div class="feature <?php echo $house->insulation ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->insulation ? 'available' : 'not-available'; ?>"><?php echo $house->insulation ? '✓' : '✘'; ?></p>
                        <?php echo $house->insulation ? ' Insulation' : ' Insulation'; ?>
                    </div>
                    <div class="feature <?php echo $house->parquet ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->parquet ? 'available' : 'not-available'; ?>"><?php echo $house->parquet ? '✓' : '✘'; ?></p>
                        <?php echo $house->parquet ? ' Parquet' : ' Parquet'; ?>
                    </div>
                    <div class="feature <?php echo $house->steelDoor ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->steelDoor ? 'available' : 'not-available'; ?>"><?php echo $house->steelDoor ? '✓' : '✘'; ?></p>
                        <?php echo $house->steelDoor ? ' Steel Door' : ' Steel Door'; ?>
                    </div>
                    <div class="feature <?php echo $house->furnished ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->furnished ? 'available' : 'not-available'; ?>"><?php echo $house->furnished ? '✓' : '✘'; ?></p>
                        <?php echo $house->furnished ? ' Furnished' : ' Furnished'; ?>
                    </div>
                    <div class="feature <?php echo $house->fiberInternet ? 'available' : 'not-available'; ?>">
                        <p class="<?php echo $house->fiberInternet ? 'available' : 'not-available'; ?>"><?php echo $house->fiberInternet ? '✓' : '✘'; ?></p>
                        <?php echo $house->fiberInternet ? ' Fiber Internet' : ' Fiber Internet'; ?>
                    </div>
                </div>
            </div>


            <div class="description">
                <h2>Description</h2>
                <p><?php echo htmlspecialchars($house->description); ?></p>
            </div>
        </div>
        <div class="contact-column">
            <div class="price-isSale">
                <div class="price">
                    <?php echo number_format($house->price, 0, '.', ','); ?>₺
                </div>

                <div class="isSale-edit">

                    <?php if ($userLogged != -1 && $house->ownerID == $userLogged): ?>
                        <?php if($house->status !== 'Sold' && $house->status !== 'Rented'): ?>
                            <div class="mark-action">
                                <span class="mark-action-badge <?php echo $house->isSale ? 'sold' : 'rent'; ?>"
                                      onclick="markAsAction('<?php echo $house->isSale ? 'sold' : 'rented'; ?>', <?php echo $house->houseID; ?>, <?php echo $house->isSale; ?>)">
                                    <?php echo $house->isSale ? 'Mark as Sold' : 'Mark as Rented'; ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Favorite Icon: Only visible if the user is logged in and is not the owner -->
                    <?php if ($userLogged != -1 && $house->ownerID != $userLogged): ?>
                        <div class="favorite-icon">
                            <!-- If the house is in favorites, add the 'active' class -->
                            <span
                                id="favoriteIcon"
                                onclick="toggleFavorite()"
                                class="favorite-icon <?php echo in_array($house->houseID, $favorites) ? 'active' : ''; ?>"
                            ></span>
                        </div>
                    <?php endif; ?>

                    <!-- Edit Button: Visible only if the user is logged in and is the owner -->
                    <div class="edit">
                        <?php if ($userLogged != -1 && $house->ownerID == $userLogged): ?>
                            <a href="editListingPage.php?id=<?php echo $houseId;?>&city=<?php echo $house->city;?>&district=<?php echo $house->district;?>&neighborhood=<?php echo $house->neighborhood;?>&street=<?php echo $house->street;?>" class="edit-listing-icon">
                                <span class="edit-icon"></span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- For Sale / For Rent / Sold / Rented Badge -->
                    <div class="isSale">
                        <span class="for-sale-badge <?php
                        if ($house->status === 'Sold' || $house->status === 'Rented') {
                            echo 'inactive';
                        } else {
                            echo $house->isSale ? 'sale' : 'rent';
                        }
                        ?>">
                            <?php
                            if ($house->status === 'Sold' || $house->status === 'Rented') {
                                echo $house->status;
                            } else {
                                echo $house->isSale ? 'For Sale' : 'For Rent';
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <div>
                <div class="contact-info-container">
                    <div class="contact-info">
                        <h3>For Detailed Information:</h3>
                    </div>
                    <div class="contact-info">
                        <img src="../Assets/user.png" alt="User Icon" class="user-icon">
                        <p><strong><?php echo $owner->name . "&nbsp;" . $owner->surname ?></strong></p>
                    </div>
                    <div class="contact-info">
                        <a href="tel:<?php echo "+90" . $owner->phone ?>" class="phone">
                            <img src="../Assets/telephone.png" alt="Phone Icon" class="phone-icon">
                            <?php echo "+90" . $owner->phone ?>
                        </a>
                    </div>
                </div>
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

    function toggleFavorite() {
        const favoriteIcon = document.getElementById('favoriteIcon');
        const houseID = <?php echo $house->houseID; ?>; // Current house ID
        const userID = <?php echo $userLogged; ?>; // Current user ID
        const isCurrentlyFavorite = favoriteIcon.classList.contains('active');

        fetch('../../Backend/houseDetailsService.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=${isCurrentlyFavorite ? 'remove' : 'add'}&houseID=${houseID}&userID=${userID}`
        })
            .then(response => {
                // Check if the response is OK
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();  // Parse as plain text, not JSON
            })
            .then(data => {
                if (data.includes('success')) {
                    // Assuming the backend returns some success message
                    favoriteIcon.classList.toggle('active');
                } else {
                    // Handle error
                    console.error('Failed to update favorites');
                    alert(data || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error. Please try again.');
            });
    }

    function markAsAction(type, houseID, isSale) {
        if (!confirm(`Are you sure you want to mark this house as ${type}?`)) {
            return;
        }

        fetch('../../Backend/houseDetailsService.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=markInactive&houseID=${houseID} &isSale=${isSale}`
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update the UI to reflect the change
                    const badge = document.querySelector('.mark-action-badge');
                    badge.style.display = 'none';  // Hide the button after successful marking

                    // Update the sale/rent badge
                    const forSaleBadge = document.querySelector('.for-sale-badge');
                    if (forSaleBadge) {
                        forSaleBadge.textContent = type === 'sold' ? 'Sold' : 'Rented';
                        forSaleBadge.classList.remove('sale', 'rent');
                        forSaleBadge.classList.add('inactive');
                    }

                    // Optional: Show success message
                    alert(`Successfully marked as ${type}`);
                } else {
                    alert(data.message || 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error. Please try again.');
            });
    }


    // Initialize with the first image
    updateImage(0);
</script>

</body>
</html>

<?php
include '../Components/footer.php';
?>
