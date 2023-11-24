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

if (isset($_SESSION['favorite_success'])) {
    echo "<script>alert('Favorited Successfully!');</script>";
    unset($_SESSION['favorite_success']);
}

if (isset($_SESSION['favorite_exist'])) {
    echo "<script>alert('Already In Favorite!');</script>";
    unset($_SESSION['favorite_exist']);
}

// Fetch platform data
$platform_name = mysqli_query($conn, "SELECT platform_name FROM platform order by id_platform asc");
$platform = mysqli_query($conn, "SELECT COUNT(app_detail.id_app) AS app_count FROM platform LEFT JOIN app_platform ON platform.id_platform = app_platform.id_platform LEFT JOIN app_detail ON app_platform.id_app = app_detail.id_app GROUP BY platform.platform_name;");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameDB</title>
    <link rel="stylesheet" href="../src/style.css">
    <style>
        /* Animation for entering from below */
        @keyframes slideInFromBottom {
            0% {
                transform: translateY(100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Apply animation to the body */
        body {
            animation: slideInFromBottom 1s ease-in-out;
        }

        .container-chart {
                width: 25%;
                margin: 15px auto;
            }
    </style>
</head>
<body>
    <div class="container-hero">
        <nav>
            <div class="logo">
                <img src="../img/game-data.png" alt="logo">
                <h1>Game&nbsp;<h1 class="blue-text">DB</h1></h1>
            </div>
            <ul>
                <li><a href="indexUser.php">Home</a></li>
                <li><a href="panelUser.php">User</a></li>
                <li><a href="https://sea.ign.com/" target="_blank">News</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
        </nav>
        <main>
            <section id="hero">
                <div class="hero-content">
                    <img src="../img/armored.png" id="bg-hero">
                    <?php
                        $sessionID = $_SESSION['id'];

                        $namaUser = "SELECT nama_user FROM user WHERE id_user = '$sessionID'";
                        $resultUser = $conn->query($namaUser);
                        if ($resultUser->num_rows > 0) {
                            while ($row = $resultUser->fetch_assoc()) {
                                $nama = $row["nama_user"];
                            }
                        }

                    ?>
                    <span class="span-hero">WELCOME, <span class="blue-underline"><?php echo $nama ?><br></span>to GameDB</span>
                </div>
            </section>
        </main>
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
                            echo "<td>" . $row['installs'] . "</td>";
                            echo "<td>" . price($row['price']) . "</td>";
                            echo "<td><a href='addToFavorites.php?id_app=" . $row['id_app'] . "'>Add to Favorites</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data available</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        <div class="container-chart">
            <canvas id="myChart" width="500" height="500"></canvas>
        </div>
    </div>
    <footer>
        <p>&copy; 2023 GameDB</p>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [<?php while ($b = mysqli_fetch_array($platform_name)) { echo '"' . $b['platform_name'] . '",';}?>],
                datasets: [{
                        label: '# of Votes',
                        data: [<?php while ($p = mysqli_fetch_array($platform)) { echo '"' . $p['app_count'] . '",';}?>],
                        backgroundColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                        ],
                        borderWidth: 1
                    }]
            },
        });
    </script>
</html>
