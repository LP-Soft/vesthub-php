<?php
//TODO:Kullanıcının giriş yapıp yapmadığını kontrol edelim
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
        <!-- Logo -->
        <div class="logo-and-title" onclick="window.location.href='mainPage.php'">
            <img src="../Assets/vesthub_logo.png" alt="Vesthub Logo">
            <p class="title">VESTHUB</p>
        </div>

        <!-- Navigation Links -->
        <div class="nav-links">
            <a href="aboutPage.php">About</a>
            <!-- Kullanıcı giriş yapmamışsa -->
            <?php
            if (isset($_SESSION['userID'])) {
            ?>
                <form action="mainPage.php" method="post">
                    <button class="logout-button" type="submit" name="logout">Logout</button>
                </form>
            <?php
            } else {
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