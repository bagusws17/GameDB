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

if (isset($_GET['reset-search'])) {
    // Redirect to the same page without any search parameters
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
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
                <li><a href="indexUser.php">Home</a></li>
                <li><a href="panelUser.php">User</a></li>
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
        <?php
        if (isset($_GET['submit-search'])) {
            $userId = $_SESSION['id'];
            // Get the search keyword
            $searchKeyword = ($_GET['search']);

            // Prepare the SQL query with a WHERE clause for app_name
            $sql = "SELECT ad.id_app, ad.app_name, ad.genre, ad.rating, ad.installs, ad.price
            FROM app_detail ad
            JOIN user_favorite uf ON ad.id_app = uf.id_app
            WHERE uf.id_user = $userId
            AND ad.app_name LIKE '%$searchKeyword%'";
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
                    echo "<td><a href='deleteFavorite.php?id_app=" . $row['id_app'] . "' style='color: red; text-decoration:none;'>Unfavorite</a></td>";
                    echo "</tr>"; 
                }
                echo '</tbody>';
                echo '</table>';

                // Add a Reset button or link
                echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='GET'>";
                echo "<button type='submit' name='reset-search' style='margin-top: 25px; background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;' name='submit-search'>Reset Search</button>";
                echo "</form>";
            } else {
                echo "<p>No data available</p>";
            }
        }
        ?>
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
                    WHERE uf.id_user = $userId ORDER BY app_name";

                    $result = $conn->query($sql);

                    // Display the favorite apps in the table
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['app_name'] . "</td>";
                            echo "<td>" . $row['genre'] . "</td>";
                            echo "<td>" . rating($row['rating']) . "</td>";
                            echo "<td>" . install($row['installs']) . "+" . "</td>";
                            echo "<td>" . price($row['price']) . "</td>";
                            echo "<td><a href='deleteFavorite.php?id_app=" . $row['id_app'] . "' style='color: red; text-decoration:none;'>Unfavorite</a></td>";
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
