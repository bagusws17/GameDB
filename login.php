<?php
include 'connection.php'; 
session_start();
 
if (isset($_SESSION['id'])) {
    header("Location: config/method.php");
}
 
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id_user'];
        $_SESSION['role'] = $row['role_user'];
        header("Location: routing.php");
    } else {
        echo "<script>alert('Wrong username or password. Please try again!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English+SC&family=Poppins:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="src/login.css">
    <style>
        .container {
            animation: fade-in 1s ease-in-out;
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="leftcon">
            <img src="img/game-data.png" alt="Logo Game Data" width="280" height="280" /><br>
            <h1>Welcome to<br>Game DB</h1>
        </div>
        <div class="login">
            <h1 class="title">Login</h1>
            <h5 class="subtitle">Don't have an account?<br><a href="register.php">Register here!</a></h5>
            <br>
            <form id="login-form" method="POST">
                <div class="text-input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Input username" required>
                    <p id="username-error" style="color: red; display: none;">Username must not contain symbols or
                        spaces</p>
                </div>
                <div class="text-input" id="password-container">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Input password" name="password" id="password" required>
                    <i class="fas fa-eye" id="eye"></i>
                </div>
                <button class="login-btn" type="submit" name="login">Log in</button>
            </form>
        </div>
    </div>
    <script>
        const passwordInput = document.querySelector("#password");
        const eye = document.querySelector("#eye");

        eye.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eye.style.opacity = 0.5;
            } else {
                passwordInput.type = "password";
                eye.style.opacity = 1;
            }
        });

        const usernameInput = document.querySelector("#username");
        const usernameError = document.querySelector("#username-error");

        usernameInput.addEventListener("input", function () {
            const username = usernameInput.value;
            if (/[\s\W]/.test(username)) {
                usernameError.style.display = "block";
            } else {
                usernameError.style.display = "none";
            }
        });
    </script>
</body>

</html>
