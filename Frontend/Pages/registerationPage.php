<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../Components/header.php';
include '../../Backend/registrationService.php';

$error_message = ""; // Initialize an error message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $city = $_POST['city'];
    $district = $_POST['district'];
    $neighborhood = $_POST['neighborhood'];

   
    // check if the user is already registered using the email
    // exists if returns true, not registered if returns false
    $success = checkAccountExists($email);
    
    if (!$success) {
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['password'] = $password;
        $_SESSION['city'] = $city;
        $_SESSION['district'] = $district;
        $_SESSION['neighborhood'] = $neighborhood;
        
        echo "<script>
                alert('Redirecting to verification page...');
                window.location.href = 'verificationPage.php';
                </script>";
        exit();
    } else {
        $error_message = "Registration failed. Email might already be in use.";
    }
        
        
    
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        #register-container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            padding: 20px 0;
        }

        #register-box {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        #logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }

        #register-title {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }

        #register-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-row {
            display: flex;
            gap: 15px;
            width: 100%;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .search-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        #register-btn {
            background-color: #b8c5a6;
            color: #333;
            padding: 12px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            width: 120px;
            margin: 20px auto 0;
            transition: background-color 0.3s;
        }

        #register-btn:hover {
            background-color: #a5b191;
        }

        #login-link {
            display: block;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        #login-link:hover {
            text-decoration: underline;
        }

        #error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            display: <?= !empty($error_message) ? 'block' : 'none' ?>;
        }

        .input-error {
            border-color: red;
        }
    </style>
</head>
<body>
    <div id="register-container">
        <div id="register-box">
            <img id="logo" src="../Assets/vesthub_logo.png" alt="Vesthub Logo">
            <h1 id="register-title">REGISTER</h1>

            <?php if (!empty($error_message)): ?>
                <div id="error-message"><?= $error_message ?></div>
                <br>
            <?php endif; ?>
            
            <form id="register-form" action="registerationPage.php" method="POST">
                <div class="input-row">
                    <input type="text" maxlength="45" minlength="1" id="name" name="name" class="input-field" placeholder="Name" required>
                    <input type="text" maxlength="45" minlength="1" id="surname" name="surname" class="input-field" placeholder="Surname" required>
                </div>
                <input type="email" maxlength="45" minlength="1" id="email" name="email" class="input-field" placeholder="E-mail" required>
                <input type="tel" maxlength="10" minlength="10" id="phone" name="phone" class="input-field" placeholder="Phone" required pattern="[0-9]{10}" title="Please enter a 10-digit phone number.">
                <input type="password" minlength="8" maxlength="16" id="password" name="password" class="input-field" placeholder="Password" required>
                <input type="password" minlength="8" maxlength="16" id="confirm_password" name="confirm_password" class="input-field" placeholder="Confirm Password" required pattern=".{8,}" title="Passwords must match" oninput="this.setCustomValidity(this.value != document.getElementById('password').value ? 'Passwords do not match' : '')">

                <div class="input-row">
                            <select class="search-select" name="city" id="city" onchange="updateDistricts()">
                                <option value="">City</option>
                                <!--Burası javascript ile dolduruluyor-->
                            </select>
                            <select class="search-select" name="district" id="district" onchange="updateNeighborhoods()">
                                <option value="">District</option>
                                <!--Burası javascript ile dolduruluyor-->
                            </select>
                            <select class="search-select" name="neighborhood" id="neighborhood">
                                <label for="neighborhood">Neighborhood</label>
                                <option value="">Neighborhood</option>
                                <!--Burası javascript ile dolduruluyor-->
                            </select>
                </div>
                <button type="submit" id="register-btn">Register</button>
                <a href="loginPage.php" id="login-link">Already have an account?</a>
            </form>
        </div>
    </div>

    <script src="../../Backend/Scripts/addressFieldHandler.js">
        
        
    </script>
</body>
</html>

<?php
include '../Components/footer.php';
?>