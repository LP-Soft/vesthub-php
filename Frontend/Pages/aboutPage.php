<?php
session_start(); // Oturum işlemleri
$isLoggedIn = isset($_SESSION['user']); // Kullanıcı giriş yapmış mı kontrolü
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPSoft Project Team</title>
    <link rel="stylesheet" href="../Styles/aboutPage.css">
    <link rel="stylesheet" href="../Styles/styles.css">
</head>
<body>

<?php include('../Components/header.php'); ?> <!-- Header kısmı dahil ediliyor -->

<!-- Ana İçerik -->
<div class="content">
    <h2>LPSoft Project Team</h2>
    <div class="team">
        <div class="team-member">
            <img src="../Assets/ali-tas.jpeg" alt="Ali Taş">
            <h3>Ali Taş</h3>
            <p>20201701054</p>
        </div>
        <div class="team-member">
            <img src="../Assets/baran-aslan.jpeg" alt="Baran Aslan">
            <h3>Baran Aslan</h3>
            <p>20201701003</p>
        </div>
        <div class="team-member">
            <img src="../Assets/mehmet-kuzucu.jpeg" alt="Mehmet Kuzucu">
            <h3>Mehmet Kuzucu</h3>
            <p>20201701065</p>
        </div>
        <div class="team-member">
            <img src="../Assets/safak-gun.jpeg" alt="Şafak Gün">
            <h3>Şafak Gün</h3>
            <p>20201701001</p>
        </div>
        <div class="team-member">
            <img src="../Assets/sevval-cetin.jpeg" alt="Şevval Çetin">
            <h3>Şevval Çetin</h3>
            <p>20201701053</p>
        </div>
    </div>
</div>

<?php include('../Components/footer.php'); ?> <!-- Footer kısmı dahil ediliyor -->

</body>
</html>