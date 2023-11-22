<?php
error_reporting(E_ALL ^ E_NOTICE and E_DEPRECATED);
$conn = mysqli_connect("localhost", "root", "", "app_info");

function login($username, $password) {
    global $conn;
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $findUser = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($findUser);
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['password'] = $user['password'];
    $_SESSION['nama_user'] = $user['nama_user'];
    $_SESSION['join_date'] = $user['join_date'];
    $_SESSION['role_user'] = $user['role_user'];

    if ($user['role'] == 'admin') {
        header("Location: ../admin/panel.php");
    } else if ($user['role'] == 'user') {
        header("Location: ../index.php");
    } else {
        echo "<script>alert('Username or password is wrong!')</script>";
    }
}


if (isset($_POST['update_data'])) {
    $id_app = isset($_POST['id_app']) ? $_POST['id_app'] : '';
    $app_name = isset($_POST['app_name']) ? $_POST['app_name'] : '';
    $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
    $installs = isset($_POST['installs']) ? $_POST['installs'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';

    // Update the record in the app_detail table
    $query = "UPDATE app_detail SET app_name = '$app_name', genre = '$genre', rating = '$rating', installs = '$installs', price = '$price' WHERE id_app = $id_app";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>