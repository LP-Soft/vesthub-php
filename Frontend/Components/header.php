<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/styles.css">
</head>

<body>

    <div class="header">
        <div class="logo-and-title" onclick="window.location.href='mainPage.php'">
            <img src="../Assets/vesthub_logo.png" alt="Vesthub Logo">
            <p class="title">VESTHUB</p>
        </div>

        <div class="nav-links">
            <a href="aboutPage.php">About</a>
            <?php
            if (isset($_SESSION['userID']) && isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
            ?>
                <a href="favoritesPage.php">Favorites</a>
                <a href="userInfoPage.php">User Info</a>
                <a href="myListingsPage.php">My Listings</a>
                <a href="newListingPage.php">Add House</a>
                <form action="mainPage.php" method="post">
                    <button class="logout-button" type="submit" name="logout">Logout</button>
                </form>
            <?php
            } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            ?>
                <a href="adminPanelPage.php">Admin Panel</a>
                <form action="mainPage.php" method="post">
                    <button class="logout-button" type="submit" name="logout">Logout</button>
                </form>

            <?php
            }
            
            else {
            ?>
                <button class="btn signin-btn" onclick="window.location.href='loginPage.php'"
                    href="loginPage.php">Sign in</button>
                <button class="btn signup-btn" onclick="window.location.href='registerationPage.php'"
                    href="registerPage.php">Sign up</button>
            <?php
            }
            ?>
        </div>
    </div>

</body>
</html>