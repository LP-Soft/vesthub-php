<?php
include '../Components/header.php';
include '../../Backend/loginService.php';

session_start();
$error_message = ""; // Initialize an error message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userID = checkLoginCredentials($email, $password);

    if ($userID == null) {
        $error_message = "Invalid email or password";
    } else {
        $_SESSION['userID'] = $userID;
        header("Location: mainPage.php");
        exit();
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>

        #login-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        #login-box {
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

        #login-title {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }

        #login-form {
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

        #create-account-link {
            display: block;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        #create-account-link:hover {
            text-decoration: underline;
        }

        #error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            display: <?= !empty($error_message) ? 'block' : 'none' ?>;
        }

        /* Error styling for input fields */
        .input-error {
            border-color: red;
        }
    </style>
</head>
<body>
    <div id="login-container">
        <div id="login-box">
            <img id="logo" src="../Assets/vesthub_logo.png" alt="Vesthub Logo">
            <h1 id="login-title">LOGIN</h1>

            <!-- Display the error message if there is one -->
            <?php if (!empty($error_message)): ?>
                <div id="error-message"><?= $error_message ?></div>
            <?php endif; ?>
            
            <form id="login-form" action="loginPage.php" method="POST" onsubmit="return validateForm()">
                <input type="email" id="email" name="email" class="input-field <?= !empty($error_message) ? 'input-error' : '' ?>" placeholder="E-mail" required>
                <input type="password" id="password" name="password" class="input-field <?= !empty($error_message) ? 'input-error' : '' ?>" placeholder="Password" required>
                <button type="submit" id="sign-in-btn">Sign in</button>
                <a href="registerationPage.php" id="create-account-link">Create an account</a>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');

            if (!email || !password) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Please fill in all fields';
                setErrorStyles();
                return false;
            }
            
            if (!email.includes('@')) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Please enter a valid email address';
                setErrorStyles();
                return false;
            }
            return true;
        }

        function setErrorStyles() {
            document.getElementById('email').classList.add('input-error');
            document.getElementById('password').classList.add('input-error');
        }
    </script>
</body>
</html>

<?php
include '../Components/footer.php';
?>
