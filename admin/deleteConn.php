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

if (isset($_SESSION['data_deleted'])) {
    echo "<script>alert('Game Platform deleted successfully');</script>";
    unset($_SESSION['data_deleted']);
}

if (isset($_SESSION['data_not_found'])) {
    echo "<script>alert('Game not exist');</script>";
    unset($_SESSION['data_not_found']);
}

// Fetch the existing data for the specific id_app
// $id_app = $_GET['id_app'];
// $app_name = $_GET['app_name'];
// $sql_check = "SELECT * FROM app_detail WHERE id_app = '$id_app' OR app_name = '$app_name'";
// $result_check = $conn->query($sql_check);
// if ($result_check->num_rows == 0) {
//     // If the combination does not exist, insert a new row
//     if (isset($_POST['submit'])) {
//         $app_name_insert = $_POST['app_name'];
//         $genre = $_POST['genre'];
//         $rating = $_POST['rating'];
//         $installs = $_POST['installs'];
//         $price = $_POST['price'];
//         $id_platform = $_POST['id_platform'];

//         $sql_insert = "INSERT INTO app_detail (app_name, genre, rating, installs, price) VALUES ('$app_name_insert', '$genre', '$rating', '$installs', '$price')";
        

//         $result_insert = $conn->query($sql_insert);
//         if ($result_insert) {
//             $sql_select = "SELECT id_app FROM app_detail WHERE app_name = '$app_name_insert'";
//             $result_select = $conn->query($sql_select);

//             $insert_data = mysqli_fetch_assoc($result_select);
//             $id_app = $insert_data['id_app'];
        
//             // Update the app_platform_insert query with the fetched id_app
//             $app_platform_insert = "INSERT INTO app_platform (id_app, id_platform) VALUES ('$id_app', '$id_platform')";

//             $_SESSION['Data has been added'] = true;
//             header("Location: insert.php");
//             exit();
//         } else {
//             echo "Error: " . $sql_insert . "<br>" . $conn->error;
//         }
//     }
// }
$sqlPlatforms = "SELECT * FROM platform";
$queryPlatforms = $conn->query($sqlPlatforms);
$platforms = [];
while ($row = $queryPlatforms->fetch_assoc()) {
    $platforms[] = $row;
}

$sqlApps = "SELECT * FROM app_detail";
$queryApps = $conn->query($sqlApps);
$apps = [];
while ($row = $queryApps->fetch_assoc()) {
    $apps[] = $row;
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
                <li><a href="insertApp.php">Add Game</a></li>
                <li><a href="insertConn.php">Platform</a></li>
                <li><a href="deleteConn.php">Delete Platform</a></li>
                <li><a href="#">Stats</a></li>
                <li><a href="https://sea.ign.com/" target="_blank">News</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
    <div class="container-content">
        <h1 style="color: white;">Delete Platform&nbsp;<span style="color: #3498db;">DB</span> Record</h1>
        <form action="deleteProcess.php" name="delete" method="post">
            <table>
                <tr>
                    <td>App Name</td>
                        <td>
                            <select name="id_app" style="background-color: white; color: black; padding: 5px; border: none; border-radius: 5px; cursor: pointer;" required>
                                <?php foreach ($apps as $app) : ?>
                                    <option value="<?php echo $app['id_app'] ?>"><?php echo $app['app_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                </tr>
                <tr>
                    <td>Platform</td>
                    <td>
                        <select name="id_platform" style="background-color: white; color: black; padding: 5px; border: none; border-radius: 5px; cursor: pointer;" required>
                            <?php foreach ($platforms as $platform) : ?>
                                <option value="<?php echo $platform['id_platform'] ?>"><?php echo $platform['platform_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                    <td></td>
                    <td>
                        <a href="deleteProcess.php.php?app_name="> </a>
                        <input type="submit" name='submit' value="Delete Conn" style="background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
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
