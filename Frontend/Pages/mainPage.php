<?php
require '../Components/header.php';
include '../../Backend/mainPageService.php';

?>
<head>
    <title>Main Page</title>
    <link rel="stylesheet" href="../Styles/mainPage.css">
</head>

<body>
    <div class="content">
        <p class="last-houses-text">Last 5 Added Houses</p>
        <div class="house-cards">
            <?php
            // Fetch all homes
            $result = getLastFiveHouses();
            // Loop through the result set and include homecard.php
            if ($result && $result->num_rows > 0) {
                while ($home = $result->fetch_assoc()) {
                    include '../Components/houseCard.php';
                }
            } else {
                echo "No homes available.";
            }
            ?>
        </div>

</body>
<?php
include '../Components/footer.php';
//closeConnection($conn);
?>