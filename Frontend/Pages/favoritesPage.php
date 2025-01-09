<?php
require_once '../Components/header.php';
require_once '../../Backend/favoritesService.php';
require_once '../Components/houseCard.php';

if (!isset($_SESSION['userID']) || (isset($_SESSION['role']) && $_SESSION['role'] == 'admin')) {
    header("Location: loginPage.php");
}

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

            if (isset($_SESSION['userID']))
            {
                $ownerID = $_SESSION['userID'];
                $result = getFavoriteHousesByOwner($ownerID);
                // Loop through the result set and display house cards
                if ($result && $result->num_rows > 0) {
                    while ($house = $result->fetch_assoc()) {
                        displayHouseCard($house, 0);
                    }
                }
                else { ?>
                    <h1>No favorites available.</h1>
                <?php
                }
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