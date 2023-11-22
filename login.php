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
        echo "<script>alert('Username atau password Anda salah. Silahkan coba lagi!')</script>";
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
        <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English+SC&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" href="src/login.css">
    </head>
    <body>
        <div class="container">
            <div class="leftcon">
                <img src="img/game-data.png" alt="Logo Game Data" width="280" height="280"/><br>
                <h1>Welcome to<br>Game Database</h1>
            </div>
            <div class="login">
                <h1 class="title">Login</h1>
                <h5 class="subtitle">Don't have an account?<br><a href="register.html">Register here!</a></h5>
                <br>
                <form id="login-form" method="POST">
                    <div class="text-input">
                        <label for="text">Username</label>
                        <input type="text" name="username" placeholder="Input username" required>
                        <p id="username-error" style="color: red; display: none;">Username must not contain symbols or spaces</p>
                </div>
                <div class="text-input" id="password-container">
                        <label for="password">Password</label>
                        <input type="password" placeholder="Input password" name="password" required>
                        <i class="fa-solid fa-eye" class="eye"></i>
                </div>
                <button class="login-btn" type="submit" name="login">Log in</button>
            </form>
            </div>
            </div>
        </div>
    </body>
    <script>
        const passwordInput = document.querySelector("#password");
        const eye = document.querySelector(".fa-eye");
        eye.addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eye.style.opacity = 1;
            } else {
                passwordInput.type = "password";
                eye.style.opacity = 0.5;
            }
        });
    </script>
</html>