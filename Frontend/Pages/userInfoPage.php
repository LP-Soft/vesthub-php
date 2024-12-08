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
    $userId = $_SESSION['userID'];
    if ($city == "") {
        echo "<script>alert('Please select your city.');</script>";
        echo "<script>window.location.href = './userInfoPage.php';</script>";
        return;
    } else if ($district == "") {
        echo "<script>alert('Please select your district.');</script>";
        echo "<script>window.location.href = './userInfoPage.php';</script>";
        return;
    } else if ($neighborhood == "") {
        echo "<script>alert('Please select your neighborhood.');</script>";
        echo "<script>window.location.href = './userInfoPage.php';</script>";
        return;
    } else if (checkEmail($email, $userId)) {
        echo "<script>alert('This email is already in use.');</script>";
        echo "<script>window.location.href = './userInfoPage.php';</script>";
        return;
    }

    updateUserInfo($name, $surname, $phone, $email, $city, $district, $neighborhood, $userId);
    //echo "<script>alert('User information updated.');</script>";
    //get request for refreshing the page
    echo "<script>window.location.href = './userInfoPage.php';</script>";
    echo "<script>alert('User information updated.');</script>";
} else if (isset($_POST['new-password'])) {
    $newPassword = $_POST['new-password']; //bu post ile alınan new password userin yeni passwordu
    $confirmPassword = $_POST['confirm-password']; //bu post ile alınan confirm password userin yeni passwordu
    $userId = $_SESSION['userID'];
    $password = $_POST['password']; //bu post ile alınan password userin mevcut passwordu
    if ($password == "") {
        echo "<script>alert('Please enter your current password.');</script>";
    } else if ($newPassword == "") {
        echo "<script>alert('Please enter a new password.');</script>";
    } else if ($confirmPassword == "") {
        echo "<script>alert('Please confirm your new password.');</script>";
    } else if (!password_verify($password, $user->password)) {
        echo "<script>alert('Current password is incorrect.');</script>";
    } else if ($newPassword == $confirmPassword) {
        updatePassword($newPassword, $userId);
    } else {
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
        document.getElementById("user-phone").innerHTML = phone;
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
            <div class="user-info-header">
                <h1 id="user-name" class="user">placeholder name</h1>
                <h3 id="user-phone" class="user">0532 123 45 67</h3>
            </div>
            <div class="user-info-body">
                <form class="user-update-inputs" action="./userInfoPage.php" method="post">
                    <div class="input-rows">
                        <div>
                            <p>Name</p>
                            <input type="text" class="name input-field" placeholder="Name" name="name" required>
                        </div>
                        <div>
                            <p>Surname</p>
                            <input type="text" class="surname input-field" placeholder="Surname" name="surname" required>
                        </div>
                    </div>
                    <div class="input-rows">
                        <div>
                            <p>Phone</p>
                            <input type="tel" maxlength="10" minlength="10" class="phone input-field" placeholder="Phone" name="phone" required>
                        </div>
                        <div>
                            <p>E-mail</p>
                            <input type="text" class="email input-field" placeholder="E-mail" name="email" required>
                        </div>
                    </div>
                    <div class="input-rows">
                        <div>
                            <p>City</p>
                            <select id="city" class="city input-field" onchange="updateDistricts()" name="city" required>
                            </select>
                        </div>
                        <div>
                            <p>District</p>
                            <select id="district" class="district input-field" onchange="updateNeighborhoods()" name="district" required>
                            </select>
                        </div>
                    </div>
                    <div class="input-row-neighborhood">
                        <p>Neighborhood</p>
                        <select id="neighborhood" class="neighborhood input-field" name="neighborhood" required>
                        </select>
                    </div>
                    <button class="user-update-button">Update</button>
                </form>
                <form class="update-password-inputs" action="./userInfoPage.php" method="post">
                    <div>
                        <p>Current Password</p>
                        <input type="password" maxlength="16" class="password input-field" placeholder="Password" name="password" required>
                    </div>
                    <div>
                        <p>New Password</p>
                        <input type="password" minlength="8" maxlength="16" class="new-password input-field" placeholder="New Password" name="new-password" required>
                    </div>
                    <div>
                        <p>Confirm New Password</p>
                        <input type="password" minlength="8" maxlength="16" class="confirm-password input-field" placeholder="Confirm New Password" name="confirm-password" required>
                    </div>
                    <button class="update-password-button">Change Password</button>
                </form>
            </div>
            <form class="delete-account-form" action="./userInfoPage.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account?');">
                <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                <button class="delete-account-button" name="delete-account">Delete Account</button>
            </form>
        </div>
    </div>
    <?php
    include '../Components/footer.php';
    ?>


</body>

</html>