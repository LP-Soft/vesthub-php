<?php
require_once '../Components/header.php';
require_once '../../Backend/favoritesService.php';
require_once '../Components/houseCard.php';
require_once '../../Classes/userInfo.php';
require_once '../../Backend/Utilities/getUserInfo.php';

if (!isset($_SESSION['userID'])) {
    header("Location: loginPage.php");
}
//Su anlik user giris yapmadigi icin userID static 2 olarak belirlendi.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Info Page</title>
    <link rel="stylesheet" href="../Styles/userInfoPage.css">
</head>
<script src="../../../Backend/Scripts/addressFieldHandler.js"></script>
<script>
    console.log("User Info Page");
    <?php
    $userID = $_SESSION['userID'];
    echo "var userID = " . $userID . ";";
    echo "console.log('userID = ' + userID);"; //konsola userID yi yazdırıyor
    
    $user = getUserInfo($userID);
    echo "console.log('user = ' + " . json_encode($user->city) . ");";
    ?>
    //change the fields with the user's information
    document.addEventListener('DOMContentLoaded', function() {
        
        let name = <?php echo json_encode($user->name); ?>;
        let surname = <?php echo json_encode($user->surname); ?>;
        let phone = <?php echo json_encode($user->phone); ?>;
        let email = <?php echo json_encode($user->email); ?>;
        let userCity = <?php echo json_encode($user->city); ?>;
        let userDistrict = <?php echo json_encode($user->district); ?>;
        let userNeighborhood = <?php echo json_encode($user->neighborhood); ?>;
        document.getElementById("user-name").innerHTML = name + " " + surname;
        document.querySelector(".user-phone").innerHTML = phone;
        document.querySelector(".name").value = name;
        document.querySelector(".surname").value = surname;
        document.querySelector(".phone").value = phone;
        document.querySelector(".email").value = email;

        console.log("DOM loaded");
        
        let citySelect = document.getElementById("city");
        let districtSelect = document.getElementById("district");
        let neighborhoodSelect = document.getElementById("neighborhood");
        const setUserCity = setInterval(() => {
            if (citySelect.options.length > 0) {
                clearInterval(setUserCity);
                
                for (let option of citySelect.options) {
                    if (option.value === userCity) {
                        option.selected = true;
                        // Trigger district update after setting city
                        updateDistricts();
                        break;
                    }
                }
            }
        }, 100);

        const setUserDistrict = setInterval(() => {
            if (districtSelect.options.length > 0) {
                clearInterval(setUserDistrict);
                
                for (let option of districtSelect.options) {
                    if (option.value === userDistrict) {
                        option.selected = true;
                        // Trigger neighborhood update after setting district
                        updateNeighborhoods();
                        break;
                    }
                }
            }
        }, 100);

        const setUserNeighborhood = setInterval(() => {
            if (neighborhoodSelect.options.length > 1) { // Check if real options loaded (>1 because of default option)
                clearInterval(setUserNeighborhood);
                                
                for (let option of neighborhoodSelect.options) {
                    if (option.value === userNeighborhood) {
                        option.selected = true;
                        break;
                    }
                }
            }
        }, 100);
    });
    
</script>

<body>
    <div class="content">
        <div class="user-info">
            <h1 id="user-name" class="user-name">placeholder name</h1>
            <h3 class="user-phone">0532 123 45 67</h3>
            <div class="user-update-inputs">
                <div>
                    <p>Name</p>
                    <input type="text" class="name user-update-input" placeholder="Name" name="name">
                </div>
                <div>
                    <p>Surname</p>
                    <input type="text" class="surname user-update-input" placeholder="Surname" name="surname">
                </div>
                <div>
                    <p>Phone</p>
                    <input type="text" class="phone user-update-input" placeholder="Phone" name="phone">
                </div>
                <div>
                    <p>E-mail</p>
                    <input type="text" class="email user-update-input" placeholder="E-mail" name="email">
                </div>
                <div>
                    <p>City</p>
                    <select id="city" class="city user-update-input" onchange="updateDistricts()" name="city">
                    </select>
                </div>
                <div>
                    <p>District</p>
                    <select id="district" class="district user-update-input"onchange="updateNeighborhoods()" name="">
                    </select>
                </div>
                <div>
                    <p>Neighborhood</p>
                    <select id="neighborhood" class="neighborhood user-update-input">
                    </select>
                </div>
                <button class="user-update-button">Update</button>
            </div>
        </div>
    </div>

</html>
<?php
include '../Components/footer.php';
?>