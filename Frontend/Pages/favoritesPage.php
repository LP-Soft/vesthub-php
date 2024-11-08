<?php
require_once '../Components/header.php';
require_once '../../Backend/favoritesService.php';
require_once '../Components/houseCard.php';

//Su anlik user giris yapmadigi icin userID static 2 olarak belirlendi.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites Page</title>
    <link rel="stylesheet" href="../Styles/favoritesPage.css">
</head>
<body>
<div class="content">
    <div class="favorites">
        <h1 class="favorites-text">Favorites</h1>
        <div class="house-cards">
            <?php
            // Fetch favorite homes
            $result = getFavoriteHousesByOwner(2);

            // Loop through the result set and display house cards
            if ($result && $result->num_rows > 0) {
                while ($house = $result->fetch_assoc()) {
                    displayHouseCard($house, 0);
                }
            } else {
                echo "No favorite homes available.";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>

<?php
//closeConnection($conn);
include '../Components/footer.php';
?>