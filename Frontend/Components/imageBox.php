<?php
function displayImageCard() {
    ?>

    <div class="image-card">
        <link rel="stylesheet" href="../Styles/imageBox.css">
        <img src="" alt="House Image" class="image-preview">

    </div>
    <span class="close-button" onclick="removeImage(this)">×</span>
    <?php
}
?>