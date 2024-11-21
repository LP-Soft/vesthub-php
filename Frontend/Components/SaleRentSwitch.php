
<?php
function displaySaleRentSwitch() {
    $isSale = isset($_POST['isSale']) ? (int)$_POST['isSale'] : 1;
    ?>
    <link rel="stylesheet" href="../Styles/saleRentSwitch.css">
    <div class="toggle-button-cover">
        <label class="radio-container">
            <input type="radio" name="isSale" value="1" 
                   <?= $isSale === 1 ? 'checked' : '' ?>>
            <span class="radio-label">Sale</span>
        </label>
        
        <label class="radio-container">
            <input type="radio" name="isSale" value="0" 
                   <?= $isSale === 0 ? 'checked' : '' ?>>
            <span class="radio-label">Rent</span>
        </label>
    </div>
    <?php
}

function displaySaleRentSwitchEdit($houseInfo) {
    $isSale = $houseInfo['isSale'];
    ?>
    <link rel="stylesheet" href="../Styles/saleRentSwitch.css">
    <div class="toggle-button-cover">
        <label class="radio-container">
            <input type="radio" name="isSale" value="1"
                <?= $isSale == 1 ? 'checked' : '' ?>>
            <span class="radio-label">Sale</span>
        </label>

        <label class="radio-container">
            <input type="radio" name="isSale" value="0"
                <?= $isSale == 0 ? 'checked' : '' ?>>
            <span class="radio-label">Rent</span>
        </label>
    </div>
    <?php
}

?>