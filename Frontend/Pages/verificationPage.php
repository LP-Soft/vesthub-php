<?php
include '../Components/header.php';
include '../../Backend/verificationService.php';
include '../../Backend/Utilities/sendMail.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['email'])) {
    header("Location: mainPage.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Generate a random verification code
    $verification_code = generateVerificationCode();

    // Send the verification code to the user's email
    sendEmail($_SESSION['email'], "Verification Code", "Your verification code is: $verification_code", "Please enter this code: $verification_code to verify your account.");

    // Set expiration time (e.g., 30 seconds from now)
    $_SESSION['verification_code_expiration'] = time() + 180;
    $_SESSION['verification_code'] = $verification_code;
}

// Calculate remaining time in PHP
$remaining_time = isset($_SESSION['verification_code_expiration']) ? max($_SESSION['verification_code_expiration'] - time(), 0) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification_code = $_POST['verification-code'];

    // Check if the verification code has expired
    if ($remaining_time <= 0) {
        $error_message = "Verification code expired. Please click the resend verification code button.";
    } else {
        // Check if the verification code is correct
        if ($verification_code === $_SESSION['verification_code']) {
            insertAccount($_SESSION['name'], $_SESSION['surname'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['password'], $_SESSION['city'], $_SESSION['district'], $_SESSION['neighborhood']);
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

        .countdown-timer {
            font-size: 18px;
            font-weight: bold;
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

        #button-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
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
            transition: background-color 0.3s;
        }

        #sign-in-btn:hover {
            background-color: #a5b191;
        }

        #resend-btn {
            background-color: #f0f0f0;
            color: #333;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            width: 100px;
            transition: background-color 0.3s;
        }

        #resend-btn:hover {
            background-color: #e0e0e0;
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
            <h1 id="verification-title">Enter the verification code sent to <?php echo $_SESSION['email'] ?> </h1>
            
            <div class="countdown-timer" id="countdown-timer">Code expires in</div>
            
            <!-- Display the error message if there is one -->
            <?php if (!empty($error_message)): ?>
                <div id="error-message"><?= $error_message ?></div>
            <?php endif; ?>
            
            <form id="verification-form" action="verificationPage.php" method="POST">
                <input type="text" class="input-field" name="verification-code" placeholder="Verification Code">

                <!-- Button container for Sign in and Resend Code -->
                <div id="button-container">
                    <button type="submit" id="sign-in-btn">Sign in</button>
                    <button type="submit" id="resend-btn" formmethod="GET" disabled>Resend Code</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const countdownElement = document.getElementById('countdown-timer');
        let remainingTime = <?= $remaining_time ?>;

        const updateTimer = () => {
            if (remainingTime > 0) {
                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;
                countdownElement.textContent = `Code expires in: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                remainingTime--;
            } else {
                countdownElement.textContent = "Code expired.";
                clearInterval(timerInterval);
            }
        };

        const timerInterval = setInterval(updateTimer, 1000);

        let cooldownTime = 30; // Cooldown time in seconds
        const resendButton = document.getElementById('resend-btn');

        const resendTimer = setInterval(() => {
            if (cooldownTime > 0) {
                resendButton.textContent = `Resend Code (${cooldownTime--})`;
            } else {
                resendButton.textContent = 'Resend Code';
                resendButton.disabled = false;
                clearInterval(resendTimer);
            }
        }, 1000);
</script>

<?php
include '../Components/footer.php';
?>
