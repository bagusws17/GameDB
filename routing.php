<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if($_SESSION['role']=='admin'){
    header("Location: admin/panel.php");
}

if($_SESSION['role']=='user'){
    header("Location: index.php");
}

?>