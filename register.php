<?php
include 'connection.php'; 
session_start();
 
if(isset($_POST['input'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['nama_user'];
    $role = 'user';
    $checkUsernameQuery = "SELECT * FROM user WHERE username = '$username'";
    $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);
    if(mysqli_num_rows($checkUsernameResult) > 0) {
            ?>
            <script>
                alert('Username already exists!');
                document.location='register.php';
            </script>
            <?php
    } else {
        // Username does not exist, insert the new user into the database
        $insert = "INSERT INTO user (username, password, nama_user, role_user) VALUES ('$username', '$password', '$name', 'user')";
        $query = mysqli_query($conn, $insert);
        if($query){
            ?>
            <script>
                alert('You are added!');
                document.location='login.php';
            </script>
            <?php
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English+SC&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="src/register.css">
    <style>
        .container {
            animation: fade-in 1s ease-in-out;
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateX(100%); /* Change the transform property to translateX(100%) */
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
            <img src="img/game-data.png" alt="Logo Game Data" width="280" height="280"/><br>
            <h1>Welcome to<br>Game Database</h1>
        </div>
        <div class="register">
            <h1 class="title">Register</h1>
            <h5 class="subtitle">Already have an account?<br><a href="login.php">Login here!</a></h5>
            <br>
            <form action='<?php $_SERVER['PHP_SELF']; ?>' name="insert" method="post">
          <div class="text-input">
                <label for="text">Username</label>
                <input type="text" name="username" id="username" placeholder="Input username" required>
                <p id="username-error" style="color: red; display: none;">Username must not contain symbols or spaces</p>
            </div>
            <div class="text-input" id="password-container">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Input password" id="password" required>
                <i class="fa-solid fa-eye" class="eye"></i>
            </div>
            <div class="text-input">
                <label for="text">Name</label>
                <input type="text" name="nama_user" placeholder="Input name" required>
            </div>
                <button class="register-btn" type="submit" name='input'>Register</button>
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
        eye.style.opacity = 0.5; // Change the opacity to indicate an off state
    } else {
        passwordInput.type = "password";
        eye.style.opacity = 1; // Restore the opacity to indicate an on state
    }
});
    
// Username must not contain symbols and spaces
const usernameInput = document.querySelector("#username");
const usernameError = document.querySelector("#username-error");
const registerForm = document.querySelector("#register-form");

let isUsernameValid = true;

usernameInput.addEventListener("input", function() {
    const username = usernameInput.value;
    if (/[\s\W]/.test(username)) { 
        usernameError.style.display = "block";
        isUsernameValid = false;
    } else {
        usernameError.style.display = "none"; 
        isUsernameValid = true;
    }
});
</script>

</html>