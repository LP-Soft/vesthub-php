<?php
require_once '../Components/header.php';
require_once '../../Backend/favoritesService.php';
require_once '../Components/houseCard.php';
require_once '../../Classes/userInfo.php';
require_once '../../Backend/Utilities/getUserInfo.php';
require_once '../../Backend/userInfoService.php';

if (!isset($_SESSION['userID'])) {
    header("Location: loginPage.php");
}
$userID = $_SESSION['userID'];
$user = getUserInfo($userID);

if (isset($_POST['delete-account'])) {
    $userID = $_POST['userID'];
    deleteUser($userID);
    session_destroy();
    header("Location: loginPage.php");
} else if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $district = $_POST['district'];
    $neighborhood = $_POST['neighborhood'];
    $password = $_POST['password'];
    $userId = $_SESSION['userID'];
    updateUserInfo($name, $surname, $phone, $email, $city, $district, $neighborhood, $userId);
}else if (isset($_POST['new-password'])) {
    $newPassword = $_POST['new-password']; //bu post ile alınan new password userin yeni passwordu
    $confirmPassword = $_POST['confirm-password']; //bu post ile alınan confirm password userin yeni passwordu
    $userId = $_SESSION['userID'];
    $password = $_POST['password']; //bu post ile alınan password userin mevcut passwordu
    if ($password == "") {
        echo "<script>alert('Please enter your current password.');</script>";
    }
    else if ($newPassword == "") {
        echo "<script>alert('Please enter a new password.');</script>";
    }
    else if ($confirmPassword == "") {
        echo "<script>alert('Please confirm your new password.');</script>";
    }
    else if (!password_verify($password, $user->password)) {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
    else if ($newPassword == $confirmPassword) {
        updatePassword($newPassword, $userId);
    }
    else {
        echo "<script>alert('Passwords do not match.');</script>";
    }
}


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
    
    echo "var userID = " . $userID . ";";
    echo "console.log('userID = ' + userID);"; //konsola userID yi yazdırıyor

    
    echo "console.log('user = ' + " . json_encode($user->city) . ");";
    ?>
    //change the fields with the user's information
    document.addEventListener('DOMContentLoaded', function() {

        let name = <?php echo json_encode($user->name); ?>;
        let surname = <?php echo json_encode($user->surname); ?>;
        let phone = <?php echo json_encode($user->phone); ?>;
        let email = <?php echo json_encode($user->email); ?>;
        let password = <?php echo json_encode($user->password); ?>;
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
            <form class="user-update-inputs" action="./userInfoPage.php" method="post">
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
                    <select id="district" class="district user-update-input" onchange="updateNeighborhoods()" name="district">
                    </select>
                </div>
                <div>
                    <p>Neighborhood</p>
                    <select id="neighborhood" class="neighborhood user-update-input" name="neighborhood">
                    </select>
                </div>
                <button class="user-update-button">Update</button>
            </form>
            <form class="update-password-inputs" action="./userInfoPage.php" method="post">
                <div>
                    <p>Current Password</p>
                    <input type="password" class="password user-update-input" placeholder="Password" name="password">
                </div>
                <div>
                    <p>New Password</p>
                    <input type="password" minlength="8" class="new-password user-update-input" placeholder="New Password" name="new-password">
                </div>
                <div>
                    <p>Confirm New Password</p>
                    <input type="password" minlength="8" class="confirm-password user-update-input" placeholder="Confirm New Password" name="confirm-password">
                </div>
                <button class="update-password-button">Change Password</button>
            </form>
            <form class="delete-account-form" action="./userInfoPage.php" method="post">
                <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                <button class="delete-account-button" name="delete-account">Delete Account</button>
            </form>
        </div>
    </div>

</html>
<?php
include '../Components/footer.php';
?>