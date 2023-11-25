<?php
include "../connection.php";
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../routing.php");
    exit();
}

// Fetch the existing data for the specific id_app
$id_app = $_GET['id_app'];
$app_name = $_GET['app_name'];
$sql_check = "SELECT * FROM app_detail WHERE id_app = '$id_app' AND app_name = '$app_name'";
$result_check = $conn->query($sql_check);
if ($result_check->num_rows == 0) {
    // If the combination does not exist, insert a new row
    if (isset($_POST['submit'])) {
        $app_name_insert = $_POST['app_name'];
        $genre = $_POST['genre'];
        $rating = $_POST['rating'];
        $installs = $_POST['installs'];
        $price = $_POST['price'];

        $sql_insert = "INSERT INTO app_detail (app_name, genre, rating, installs, price) VALUES ('$app_name_insert', '$genre', '$rating', '$installs', '$price')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert) {
            $_SESSION['Data has been added'] = true;
            header("Location: insert.php");
            exit();
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }
}

// Display the form for inserting new data
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert GameDB Record</title>
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
                <h1>Game DB</h1>
            </div>
            <ul>
                <li><a href="panel.php">Games</a></li>
                <li><a href="insert.php">Add</a></li>
                <li><a href="#">Stats</a></li>
                <li><a href="https://sea.ign.com/" target="_blank">News</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
    <div class="container-content">
        <h1 style="color: white;">Insert Game&nbsp;<span style="color: #3498db;">DB</span> Record</h1>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" name="insert" method="post">
            <table>
                <tr>
                    <td>App Name</td>
                    <td><input type="text" name="app_name" required></td>
                </tr>
                <tr>
                    <td>Genre</td>
                    <td>
                        <select name="genre" required>
                            <option value="FPS">FPS</option>
                            <option value="RPG">RPG</option>
                            <option value="Simulation">Simulation</option>
                            <option value="Strategy">Strategy</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Rating</td>
                    <td><input type="number" step="any" name="rating" required></td>
                </tr>
                <tr>
                    <td>Installs</td>
                    <td><input type="number" name="installs" required></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type="number" name="price" required></td>
                </tr>
                <tr>
                <tr>
                    <td>Platform</td>
                    <td>
                        <select name="genre" required>
                            <option value="FPS">FPS</option>
                            <option value="RPG">RPG</option>
                            <option value="Simulation">Simulation</option>
                            <option value="Strategy">Strategy</option>
                        </select>
                    </td>
                </tr>
                    <td></td>
                    <td>
                        <input type="submit" name='submit' value="Insert Data Game" style="background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <footer>
        <p>&copy; 2023 GameDB</p>
    </footer>
</body>

</html>
