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
    $installs = $_POST['installs'];
    $price = $_POST['price'];

    $update = "update app_detail set id_app='$id', app_name='$app_name', genre='$genre', rating='$rating', installs='$installs', price='$price' where id_app='$idupdate'";
    $query = mysqli_query($conn,$update);
    if($query){
        ?>
        <script>
            alert('Data berhasil Diubah!');
            document.location='panel.php';
        </script>
        <?php
    }
}

if($hasil['id_app']!=""){
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update GameDB Record</title>
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
                <li><a href="../login.php">Login</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
    <div class="container-content">
        <h2>Update GameDB Record</h2>
        <form action='<?php $_SERVER['PHP_SELF']; ?>' name="update" method="post">
        <table>
            <tr>
              <td>Id Game</td>
              <td><input type="text" name="id_app" maxlength="5" required value='<?php echo $hasil['id_app']; ?>'></td>  
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
              <td><input type="number" name="rating" required value='<?php echo $hasil['rating']; ?>'></td>  
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
                    <input type="submit" name='update' value="Edit Data Game">
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
<?php
}
?>