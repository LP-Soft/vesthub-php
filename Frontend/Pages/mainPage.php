<?php
require_once '../../Database/databaseController.php';
include '../Components/header.php';
// Fetch all homes
$result = getAllHomes($conn);

// Loop through the result set and include homecard.php
$counter=0;
if ($result && $result->num_rows > 0) {
    while ($home = $result->fetch_assoc()) {
        include '../Components/houseCard.php';
        $counter++;
    }
} else {
    echo "No homes available.";
}

closeConnection($conn);
echo "  <div class='content'>
            <h1>Toplamda ".$counter." ev bulunmaktadır.</h1>
        </div>";
include '../Components/footer.php';
?>
<head>
    <title>Vesthub Main Page</title>
    <link rel="stylesheet" href="../Styles/mainPage.css">
</head>