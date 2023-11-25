<?php
    include "../connection.php";
    session_start();

    $id_app = $_POST['id_app'];
    $id_platform = $_POST['id_platform'];

    $sql_check = "SELECT * FROM app_platform WHERE id_app = '$id_app' AND id_platform = '$id_platform'";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows == 0) {
        // If the combination does not exist, insert a new row
        $sql_insert = "INSERT INTO app_platform (id_app, id_platform) VALUES ('$id_app', '$id_platform')";
        $result_insert = $conn->query($sql_insert);
        if ($result_insert) {
            $_SESSION['data_added'] = true;
            header("Location: insert.php");
            exit();
            if ($result_insert_platform) {
                $_SESSION['data_added'] = true;
                header("Location: insert.php");
                exit();
            } else {
                echo "Error: " . $sql_insert_platform . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    } else {
        $_SESSION['data_exists'] = true;
        header("Location: insert.php");
    }
?>