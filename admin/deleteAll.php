<?php
include "../connection.php";
session_start();

$sessionID = $_SESSION['id'];

if (isset($_GET['del'])) {
    $id_app = (int)$_GET['del']; // Convert to integer
    // Start a transaction
    mysqli_autocommit($conn, false);

    // Use prepared statements to avoid SQL injection
    $sql_delete_app_platform = "DELETE FROM app_platform WHERE id_app = ?";
    $stmt_delete_app_platform = $conn->prepare($sql_delete_app_platform);
    $stmt_delete_app_platform->bind_param("i", $id_app);
    $result_delete_app_platform = $stmt_delete_app_platform->execute();

    $sql_delete_user_favorite = "DELETE FROM user_favorite WHERE id_app = ?";
    $stmt_delete_user_favorite = $conn->prepare($sql_delete_user_favorite);
    $stmt_delete_user_favorite->bind_param("i", $id_app);
    $result_delete_user_favorite = $stmt_delete_user_favorite->execute();

    $sql_delete_app_detail = "DELETE FROM app_detail WHERE id_app = ?";
    $stmt_delete_app_detail = $conn->prepare($sql_delete_app_detail);
    $stmt_delete_app_detail->bind_param("i", $id_app);
    $result_delete_app_detail = $stmt_delete_app_detail->execute();

    // Commit or rollback the transaction based on the results
    if ($result_delete_app_platform && $result_delete_user_favorite && $result_delete_app_detail) {
        mysqli_commit($conn);
        $_SESSION['game_deleted'] = true;
        header("Location: panel.php");
        exit();
    } else {
        mysqli_rollback($conn);
        echo "Error deleting record: " . $conn->error;
        header("Location: panel.php");
        exit();
    }

    // Clean up
    mysqli_autocommit($conn, true);
} else {
    echo "Invalid request";
    header("Location: panel.php");
    exit();
}
?>
