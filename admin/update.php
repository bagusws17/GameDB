<?php
include "../connection.php";
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
  }
  
  if($_SESSION['role']!='admin'){
    header("Location: ../routing.php");
    exit();
  }

  $idupdate = $_GET['id'];

  $hasil = mysqli_fetch_array(mysqli_query($conn, "select * from app_detail where id_app='$idupdate'"));

  if(isset($_POST['update'])){
    $id = $_POST['id_app'];
    $app_name = $_POST['app_name'];
    $genre = $_POST['genre'];
    $rating = $_POST['rating'];
    $rating_con = str_replace(",",".",$rating);
    $installs = $_POST['installs'];
    $price = $_POST['price'];

    // Prepare the update statement
    $update = "UPDATE app_detail SET app_name=?, genre=?, rating=?, installs=?, price=? WHERE id_app=?";
    $stmt = $conn->prepare($update);

    // Bind parameters and execute the statement
    $stmt->bind_param("sssiii", $app_name, $genre, $rating_con, $installs, $price, $idupdate);
    $stmt->execute();

    if($stmt){
        ?>
        <script>
            alert('Data Successfully Updated!');
            document.location='panel.php';
        </script>
        <?php
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update GameDB Record</title>
    <link rel="stylesheet" href="../src/panel.css">
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
        <h2 style="color: #3498db;">Update GameDB Record</h2>
        <form action='<?php $_SERVER['PHP_SELF']; ?>' name="update" method="post">
        <table>
            <tr>
              <td>Id Game</td>
              <td><input type="number" name="id_app" maxlength="5" required value='<?php echo $hasil['id_app']; ?>' readonly></td>  
            </tr>
            <tr>
              <td>App Name</td>
              <td><input type="text" name="app_name" required value='<?php echo $hasil['app_name']; ?>'></td>  
            </tr>
            <tr>
              <td>Genre</td>
              <td>
                <select name="genre" required>
                    <option value="FPS" <?php echo ($hasil['genre'] == 'FPS') ? 'selected' : ''; ?>>FPS</option>
                    <option value="RPG" <?php echo ($hasil['genre'] == 'RPG') ? 'selected' : ''; ?>>RPG</option>
                    <option value="Simulation" <?php echo ($hasil['genre'] == 'Simulation') ? 'selected' : ''; ?>>Simulation</option>
                    <option value="Strategy" <?php echo ($hasil['genre'] == 'Strategy') ? 'selected' : ''; ?>>Strategy</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Rating</td>
              <td><input type="number" name="rating" required value='<?php echo $hasil['rating']; ?>'>
              <span style="color: gray; font-size: 12px;"><br>Insert number of tens (e.g., 45), it will be converted. Max: 50</span> 
              </td>
            </tr>
            <tr>
              <td>Installs</td>
              <td><input type="number" name="installs" required value='<?php echo $hasil['installs']; ?>'></td>  
            </tr>
            <tr>
              <td>Price</td>
              <td><input type="number" name="price" required value='<?php echo $hasil['price']; ?>'></td>  
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name='update' style="background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;" value="Edit Data Game">
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
