<?php
include "../connection.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redirect to login.php
    exit();
}

$del=$_GET['del'];
if($del!=""){
    $sql = "delete from app_detail where id_app='$del'";
    $query = mysqli_query($conn, $sql);
    if($query){
    ?>
    <script>alert('Data Deleted Succesfully');document.location='panel.php';</script>
    <?php
    }
}

function price($price){
    $formattedprice = "Rp " . number_format($price, 2, ',', '.');
    return $formattedprice;
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
                <li><a href="#">Home</a></li>
                <li><a href="#">Games</a></li>
                <li><a href="#">User</a></li>
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
                    $sql = "SELECT * FROM app_detail";
                    $result = $conn->query($sql);

                    // Menampilkan data ke dalam tabel
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['app_name'] . "</td>";
                            echo "<td>" . $row['genre'] . "</td>";
                            echo "<td>" . $row['rating'] . "</td>";
                            echo "<td>" . $row['installs'] . "+" . "</td>";
                            echo "<td>" . price($row['price']) . "</td>";
                            echo "<td> <a href='update.php?id=$row[id_app]'>Edit</a>
                            <a href='panel.php?id=$row[id_app]'>Delete</a></td>
                            </tr>"
                            ;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data available</td></tr>";
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
