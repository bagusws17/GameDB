<?php
    include "../connection.php";
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: ../login.php"); // Redirect to login.php
        exit();
    }

    $id_user = $_SESSION['id'];
    $id_app = $_GET['id_app'];
    $date_added = date("Y-m-d");

    $sql_check = "SELECT * FROM user_favorite WHERE id_user = '$id_user' AND id_app = '$id_app'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 0) {
        // If the combination does not exist, insert a new row
        $sql_insert = "INSERT INTO user_favorite (id_user, id_app, date_added) VALUES ('$id_user', '$id_app', '$date_added')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert) {
            $_SESSION['favorite_success'] = true;
            header("Location: indexUser.php");
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    } else {
        $_SESSION['favorite_exist'] = true;
        header("Location: indexUser.php");
    }
?>