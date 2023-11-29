<?php
include "../connection.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redirect to login.php
    exit();
}

if (isset($_SESSION['game_deleted'])) {
    echo "<script>alert('Game deleted successfully');</script>";
    unset($_SESSION['game_deleted']);
}

function price($price)
{
    $formattedprice = "Rp " . number_format($price, 2, ',', '.');
    return $formattedprice;
}

function install($installs)
{
    $formattedinstalls = number_format($installs, 0, '.', '.');
    return $formattedinstalls;
}

function rating($rating)
{
    $formattedrating = number_format($rating / 10, 1);
    return $formattedrating;
}


// Fetch platform data
$platform_name = mysqli_query($conn, "SELECT platform_name, id_platform FROM platform ORDER BY id_platform ASC");
$platform = mysqli_query($conn, "SELECT platform_name, COUNT(app_detail.id_app) AS app_count FROM platform LEFT JOIN app_platform ON platform.id_platform = app_platform.id_platform LEFT JOIN app_detail ON app_platform.id_app = app_detail.id_app GROUP BY platform.platform_name, platform.id_platform ORDER BY platform.id_platform ASC;");

if (isset($_GET['reset-search'])) {
    // Redirect to the same page without any search parameters
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch game statistics by genre
$genre_data_result = mysqli_query($conn, "SELECT genre, COUNT(id_app) AS game_count FROM app_detail GROUP BY genre ORDER BY game_count DESC");

// Fetch data into an array
$genre_data = array();
while ($row = mysqli_fetch_assoc($genre_data_result)) {
    $genre_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameDB</title>
    <link rel="stylesheet" href="../src/panel.css">
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
        .container-content {
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
                <li><a href="panel.php">Games</a></li>
                <li><a href="insertApp.php">Add Game</a></li>
                <li><a href="insertConn.php">Platform</a></li>
                <li><a href="deleteConn.php">Delete Platform</a></li>
                <li><a href="#container-chart">Stats</a></li>
                <li><a href="https://sea.ign.com/" target="_blank">News</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
    <div class="container-content">
        <div class="title">
            <div class="subtitle">
                Database of Game.
            </div>
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
            <h1 class="white-text">Welcome to GameDB, <?php echo $nama ?></h1>
            <p class="white-text">GameDB is the ultimate resource for Gamers. We track everything from games and apps to DLC and stats. We also have a wealth of news and information about Game.</p>
            <p class="white-text">Whether you're a gamer or a seasoned veteran, GameDB has something for everyone.</p>
        </div>
        <div class="search-container">
            <form class="form-search" action='<?php $_SERVER['PHP_SELF']; ?>' method="GET">
                <input type="text" id="search" class="search-input" placeholder="Search..." name="search">
                <button type="submit" class="search-button" style="background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;" name="submit-search">Search</button>
            </form>
        </div>
        <?php
        if (isset($_GET['submit-search'])) {
            // Get the search keyword
            $searchKeyword = ($_GET['search']);

            // Prepare the SQL query with a WHERE clause for app_name
            $sql = "SELECT * FROM app_detail WHERE app_name LIKE '%$searchKeyword%'";
            $result = $conn->query($sql);

            // Display the search results in a table
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Game Name</th>';
                echo '<th>Genre</th>';
                echo '<th>Rating</th>';
                echo '<th>Installs</th>';
                echo '<th>Price</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['app_name'] . "</td>";
                    echo "<td>" . $row['genre'] . "</td>";
                    echo "<td>" . rating($row['rating']) . "</td>";
                    echo "<td>" . install($row['installs']) . "+" . "</td>";
                    echo "<td>" . price($row['price']) . "</td>";
                    echo "<td> <a href='update.php?id=$row[id_app] . 'style='color: #FFFF00; text-decoration:none;'>Edit</a>
                    <a href='deleteAll.php?del=$row[id_app] . 'style='color: red; text-decoration:none;'>Delete</a></td>
                    </tr>";
                    echo "</tr>";
                }

                echo '</tbody>';
                echo '</table>';

                // Add a Reset button or link
                echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='GET'>";
                echo "<button type='submit' name='reset-search' style='margin-top: 25px; background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;' name='submit-search'>Reset Search</button>";
                echo "</form>";
            } else {
                echo "<p style='color: #3498db;'>No data available</p>";
                echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='GET'>";
                echo "<button type='submit' name='reset-search' style='margin-top: 25px; background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;' name='submit-search'>Reset Search</button>";
                echo "</form>";
            }
        }
        ?>
        <h1 class="white-text">List of Game</h1>
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
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['app_name'] . "</td>";
                        echo "<td>" . $row['genre'] . "</td>";
                        echo "<td>" . rating($row['rating']) . "</td>";
                        echo "<td>" . install($row['installs']) . "+" . "</td>";
                        echo "<td>" . price($row['price']) . "</td>";
                        echo "<td> <a href='update.php?id=$row[id_app] . 'style='color: #FFFF00; text-decoration:none;'>Edit</a>
                            <a href='deleteAll.php?del=$row[id_app] . 'style='color: red; text-decoration:none;'>Delete</a></td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container-for-chart" style="display: flex; flex-direction: row; justify-content: space-around;">
        <div class="container-chart" id="container-chart">
            <h1 style="display: flex; justify-content: space-around; align-items: center; font-weight: bold; font-size: 18px; text-align: center;color: #A2FACF;">Platform</h1>
            <canvas id="myChart" width="500" height="500"></canvas>
        </div>
        <div class="container-chart">
            <h1 style="display: flex; justify-content: space-around; align-items: center; font-weight: bold; font-size: 18px; text-align: center;color: #A2FACF;">Genre</h1>
            <canvas id="myChart2" width="500" height="500"></canvas>
        </div>
    </div>
    <footer>
        <p>&copy; 2023 GameDB</p>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
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
        }, 1000);
    });

    document.addEventListener("DOMContentLoaded", function () {
                setTimeout(function () {
                    var ctx = document.getElementById("myChart2");
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: [<?php foreach ($genre_data as $g) { echo '"' . $g['genre'] . '",'; } ?>],
                            datasets: [{
                                data: [<?php foreach ($genre_data as $g) { echo '"' . $g['game_count'] . '",'; } ?>],
                                backgroundColor: [
                                    'rgba(176, 64, 64, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(52, 152, 219, 1)',
                                    'rgba(255, 236, 0, 1)',
                                ],
                                borderColor: [
                                    'rgba(176, 64, 64, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(52, 152, 219, 1)',
                                    'rgba(255, 236, 0, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                    });
                }, 1000);
            });

    document.querySelector('a[href="#container-chart"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#container-chart').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

</script>

</html>
