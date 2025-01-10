<?php
include '../Components/header.php';
include '../../Backend/loginService.php';

$error_message = ""; // Initialize an error message variable
if (isset($_SESSION['userID'])) {
    if($_SESSION['role'] == 'admin'){
        header("Location: adminPanelPage.php");
    }else {
        header("Location: mainPage.php");
    }
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $arr = checkLoginCredentials($email, $password);

    //check if arr is empty
    if (empty($arr)) {
        $error_message = "Invalid email or password";
    } else {
        $_SESSION['userID'] = $arr['userID'];
        $_SESSION['role'] = $arr['role'];
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
    <link rel="stylesheet" href="../Styles/loginPage.css">
    <style>
        #error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            display: <?= !empty($error_message) ? 'block' : 'none' ?>;
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
