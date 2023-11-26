<?php
    include "../connection.php";
    session_start();

    $id_app = $_POST['id_app'];
    $id_platform = $_POST['id_platform'];

    $sql_check = "SELECT * FROM app_platform WHERE id_app = '$id_app' AND id_platform = '$id_platform'";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows > 0) {
        // If the combination exists, delete the row
        $sql_delete = "DELETE FROM app_platform WHERE id_app = '$id_app' AND id_platform = '$id_platform'";
        $result_delete = $conn->query($sql_delete);
        if ($result_delete) {
            $_SESSION['data_deleted'] = true;
            header("Location: deleteConn.php");
            exit();
        } else {
            echo "Error: " . $sql_delete . "<br>" . $conn->error;
        }
    } else {
        $_SESSION['data_not_found'] = true;
        header("Location: deleteConn.php");
    }
?>