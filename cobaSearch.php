<?php
include "connection.php";
session_start();

function price($price){
    $formattedprice = "Rp " . number_format($price, 2, ',', '.');
    return $formattedprice;
}

function install($installs)
{
    $formattedinstalls = number_format($installs, 0, '.', '.');
    return $formattedinstalls;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameDB</title>
    <link rel="stylesheet" href="src/style.css">
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
        .hero-content {
            animation: slideInFromBottom 1s ease-in-out;
        }

        .container-content {
            animation: slideInFromBottom 1s ease-in-out;
        }

        .container-chart {
            width: 25%;
            margin: 15px auto;
            animation: slideInFromBottom 1s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container-hero" id="container-hero">
        <nav>
            <div class="logo">
                <img src="img/game-data.png" alt="logo">
                <h1>Game&nbsp;<h1 class="blue-text">DB</h1></h1>
            </div>
            <ul>
                <li><a href="#container-hero">Home</a></li>
                <li><a href="#container-content">Games</a></li>
                <li><a href="#container-chart">Stats</a></li>
                <li><a href="https://sea.ign.com/" target="_blank">News</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
        <main>
            <section id="hero">
                <div class="hero-content">
                    <img src="img/armored.png" id="bg-hero">
                    <span class="span-hero">WELCOME <span class="blue-underline">GAMER<br></span>to GameDB</span>
                </div>
            </section>
        </main>
    </div>
    <div class="container-content" id="container-content">
        <div class="title">
            <div class="subtitle">
                Database of Game.
            </div>
            <h1 class="white-text">Welcome to GameDB</h1>
            <p class="white-text">GameDB is the ultimate resource for Gamers. We track everything from games and apps to DLC and stats. We also have a wealth of news and information about Game.</p>
            <p class="white-text">Whether you're a gamer or a seasoned veteran, GameDB has something for everyone.</p>
        </div>
        <div class="search-container">
            <form class="form-search" action='<?php $_SERVER['PHP_SELF']; ?>' method="GET">
                <input type="text" id="search" class="search-input" placeholder="Search..." name="search">
                <button type="submit" class="search-button" style="background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;" name="submit-search">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Game Name</th>
                    <th>Genre</th>
                    <th>Rating</th>
                    <th>Installs</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($_GET['submit-search'])) {
                        // Get the search keyword
                        $searchKeyword = ($_GET['search']);

                        // Prepare the SQL query with a WHERE clause for app_name
                        $sql = "SELECT * FROM app_detail WHERE app_name LIKE '%$searchKeyword%'";
                        $result = $conn->query($sql);

                        // Display the search results in a table
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['app_name'] . "</td>";
                                echo "<td>" . $row['genre'] . "</td>";
                                echo "<td>" . $row['rating'] . "</td>";
                                echo "<td>" . install($row['installs']) . "+" . "</td>";
                                echo "<td>" . price($row['price']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No data available</td></tr>";
                        }
                    }
                    ?>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Game Name</th>
                    <th>Genre</th>
                    <th>Rating</th>
                    <th>Installs</th>
                    <th>Price</th>
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
                            echo "<td>" . install($row['installs']) . "+" . "</td>";
                            echo "<td>" . price($row['price']) . "</td>";
                            echo "</tr>";
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
<script>

    // Scroll to top when clicking on the Home link
    document.querySelector('a[href="#container-hero"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#container-hero').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    document.querySelector('a[href="#container-content"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#container-content').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    document.querySelector('a[href="#container-chart"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#container-chart').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
</script>
</html>
