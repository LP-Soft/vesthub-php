<?php
include '../Components/header.php';
include '../../Backend/verificationService.php';
include '../../Backend/Utilities/sendMail.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Generate a random verification code
    $verification_code = generateVerificationCode(); 

    // send the verification code to the user's email
    sendEmail($_SESSION['email'], "Verification Code", "Your verification code is: $verification_code", "Please enter this code: $verification_code to verify your account.");

    // store the verification code in session
    $_SESSION['verification_code'] = $verification_code;
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification_code = $_POST['verification-code'];


    // check if the verification code is correct
    // if correct, redirect to the main page
    // if not, display an error message
    if ($verification_code === $_SESSION['verification_code']) {
        // save the user to the database
        insertAccount($_SESSION['name'], $_SESSION['surname'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['password'], $_SESSION['city'], $_SESSION['district'], $_SESSION['neighborhood']);
        // delete the session variables
        session_unset();
        session_destroy();
        echo "<script>
                    alert('Verification successful. Redirecting to Login page. Please login to continue.');
                    window.location.href = 'loginPage.php';
                  </script>";
        exit();
    } else {
        $error_message = "Invalid verification code";
    }
}




?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Page</title>
    <style>

        #verification-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        #verification-box {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        #logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }

        #verification-title {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }

        #verification-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        #sign-in-btn {
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

        #sign-in-btn:hover {
            background-color: #a5b191;
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
    <div id="verification-container">
        <div id="verification-box">
            <img id="logo" src="../Assets/vesthub_logo.png" alt="Vesthub Logo">
            <h1 id="verification-title">Enter the verification code sent to ******@gmail.com</h1>

            <!-- Display the error message if there is one -->
            <?php if (!empty($error_message)): ?>
                <div id="error-message"><?= $error_message ?></div>
            <?php endif; ?>
            
            <form id="verification-form" action="verificationPage.php" method="POST" onsubmit="return validateForm()">
                <input type="text" class="input-field" name="verification-code" placeholder="Verification Code">
                <button type="submit" id="sign-in-btn">Sign in</button>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            const verification_code = document.getElementById('verification-code').value;

            if (verificationCode.length !== 6) {
                alert('Verification code must be 6 characters long');
                return false;
            }

            return true;
        }
    </script>



<?php
include '../Components/footer.php';
?>