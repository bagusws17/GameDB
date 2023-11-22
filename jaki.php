<?php
include "../inc/koneksi.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../index.php");
  exit();
}

if($_SESSION['role']!='admin'){
  header("Location: ../routing.php");
  exit();
}

$idupdate = $_GET['id'];

$hasil = mysqli_fetch_array(mysqli_query($conn, "select * from barang where id_barang='$idupdate'"));

if(isset($_POST['update'])){
    $id = $_POST['id_barang'];
    $nama = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $supplier = $_POST['supplier'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    $update = "update barang set id_barang='$id', nama_barang='$nama', stok='$stok', harga_beli='$harga_beli', harga_jual='$harga_jual', id_supplier='$supplier' where id_barang='$idupdate'";
    $query = mysqli_query($conn,$update);
    if($query){
        ?>
        <script>
            alert('Data berhasil Diubah!');
            document.location='view.php';
        </script>
        <?php
    }
}

if($hasil['id_barang']!=""){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <title>Insert</title>
    <style>
      body{
        text-align: center;
      }
      table {
        margin: auto;
      }
      td {
        text-align: left;
        padding: 5px;
      }
    </style>
    </head>
    <body>
    <h1>Edit Data Barang</h1>
    <form action='<?php $_SERVER['PHP_SELF']; ?>' name="update" method="post">
        <table>
            <tr>
              <td>Id Barang</td>
              <td><input type="text" name="id_barang" maxlength="5" required value='<?php echo $hasil['id_barang']; ?>'></td>  
            </tr>
            <tr>
              <td>Nama</td>
              <td><input type="text" name="nama_barang" required value='<?php echo $hasil['nama_barang']; ?>'></td>  
            </tr>
            <tr>
              <td>Stok</td>
              <td><input type="number" name="stok" required value='<?php echo $hasil['stok']; ?>'></td>  
            </tr>
            <tr>
              <td>Supplier</td>
              <td>
                <select name="supplier">
                  <?php
                  $s = "select * from supplier";
                  $q = mysqli_query($conn, $s);
                  while($row=mysqli_fetch_array($q)){
                    if($row['id_supplier']==$hasil['id_supplier']){
                      echo "<option value='$row[id_supplier]' selected>$row[nama_supplier]</option>";
                    }else{
                      echo "<option value='$row[id_supplier]'>$row[nama_supplier]</option>";
                    }                 
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>Harga Beli</td>
              <td><input type="number" name="harga_beli" required value='<?php echo $hasil['harga_beli']; ?>'></td>  
            </tr>
            <tr>
              <td>Harga Jual</td>
              <td><input type="number" name="harga_jual" required value='<?php echo $hasil['harga_jual']; ?>'></td>  
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name='update' value="Edit Data Game">
                </td>
            </tr>
        </table>
    </form>
    </body>
    </html>
    <?php
}
?>