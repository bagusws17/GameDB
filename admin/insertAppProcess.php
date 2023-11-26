<?php
    include "../connection.php";
    session_start();

    $app_name_insert = $_POST['app_name'];
    $genre = $_POST['genre'];
    $rating = $_POST['rating'];
    $installs = $_POST['installs'];
    $price = $_POST['price'];

    $sql_check = "SELECT * FROM app_detail WHERE app_name = '$app_name_insert'";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows == 0) {
        // If the combination does not exist, insert a new row
        $sql_insert = "INSERT INTO app_detail (app_name, genre, rating, installs, price) VALUES ('$app_name_insert', '$genre', '$rating', '$installs', '$price')";
        $result_insert = $conn->query($sql_insert);
        if ($result_insert) {
            $_SESSION['data_added'] = true;
            header("Location: insertApp.php");
            exit();
            if ($result_insert_platform) {
                $_SESSION['data_added'] = true;
                header("Location: insertApp.php");
                exit();
            } else {
                echo "Error: " . $sql_insert_platform . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    } else {
        $_SESSION['data_exists'] = true;
        header("Location: insertApp.php");
    }
?>