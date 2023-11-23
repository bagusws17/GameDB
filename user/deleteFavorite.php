<?php
include "../connection.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redirect to login.php
    exit();
}

if (isset($_GET['id_app'])) {
    $id_app = $_GET['id_app'];
    $sessionID = $_SESSION['id'];

    // Perform the deletion
    $sql = "DELETE FROM user_favorite WHERE id_user = '$sessionID' AND id_app = '$id_app'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['delete_success'] = true;
        header("Location: panelUser.php");
    exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    header("Location: panelUser.php");
    exit();
} else {
    echo "Invalid request";
    header("Location: panelUser.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameDB</title>
    <link rel="stylesheet" href="../src/style.css">
</head>