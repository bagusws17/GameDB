<?php
include "../connection.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redirect to login.php
    exit();
}

function price($price){
    $formattedprice = "Rp " . number_format($price, 2, ',', '.');
    return $formattedprice;
}

if (isset($_SESSION['delete_success'])) {
    echo "<script>alert('Record deleted successfully');</script>";
    unset($_SESSION['delete_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameDB</title>
    <link rel="stylesheet" href="../src/admin.css">
</head>
<body>
    <div class="container-hero">
        <nav>
            <div class="logo">
                <img src="../img/game-data.png" alt="logo">
                <h1>Game DB</h1>
            </div>
            <ul>
                <li><a href="indexUser.php">Home</a></li>
                <li><a href="#">Games</a></li>
                <li><a href="panelUser.php">User</a></li>
                <li><a href="#">Stats</a></li>
                <li><a href="#">News</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
    <div class="container-content">
            <div class="title">
                <div class="subtitle">
                    Database of Game.
                </div>
                <h1 class="white-text">Welcome to GameDB</h1>
                <p class="white-text">GameDB is the ultimate resource for Gamers. We track everything from games and apps to DLC and stats. We also have a wealth of news and information about Game.</p>
                <p class="white-text">Whether you're a gamer or a seasoned veteran, GameDB has something for everyone.</p>
            </div>
        <div class="search-container">
            <input type="text" id="search" class="search-input" placeholder="Search...">
        </div>
        <table>
            <thead>
                <tr>
                    <th>Game Name</th>
                    <th>Genre</th>
                    <th>Rating</th>
                    <th>Installs</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $userId = $_SESSION['id'];

                    // SQL query to retrieve user's favorite apps
                    $sql = "SELECT ad.id_app, ad.app_name, ad.genre, ad.rating, ad.installs, ad.price
                            FROM app_detail ad
                            JOIN user_favorite uf ON ad.id_app = uf.id_app
                            WHERE uf.id_user = $userId";

                    $result = $conn->query($sql);

                    // Display the favorite apps in the table
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['app_name'] . "</td>";
                            echo "<td>" . $row['genre'] . "</td>";
                            echo "<td>" . $row['rating'] . "</td>";
                            echo "<td>" . $row['installs'] . "</td>";
                            echo "<td>" . price($row['price']) . "</td>";
                            echo "<td><a href='deleteFavorite.php?id_app=" . $row['id_app'] . "'>Unfavorite</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No favorite apps added yet.</td></tr>";
                    }

                ?>
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; 2023 GameDB</p>
    </footer>
</body>
</html>
