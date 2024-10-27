<?php
//TODO:Kullanıcının giriş yapıp yapmadığını kontrol edelim

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vesthub Header</title>
    <link rel="stylesheet" href="../Styles/styles.css">
</head>
<body>

<div class="header">
    <!-- Logo -->
    <div class="logo-and-title">
        <img src="../Assets/vesthub_logo.png" alt="Vesthub Logo">
        <p class="title">VESTHUB</p>
    </div>

    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="#">About</a>
        <!-- Kullanıcı giriş yapmamışsa -->
        <button class="btn signin-btn">Sign in</button>
        <button class="btn signup-btn">Sign up</button>
    </div>
</div>

</body>
</html>