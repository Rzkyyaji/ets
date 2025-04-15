<?php include 'koneksi.php';
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = $id");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head><title>Edit Buku</title><link rel="stylesheet" href="style/main.css"></head>
<body>
<h2>Edit Buku</h2>
<form method="post">
  <input type="hidden" name="id" value="<?= $id ?>">
  <label>Judul:</label><input type="text" name="judul" value="<?= $data['judul'] ?>" required><br>
  <label>Penulis:</label><input type="text" name="penulis" value="<?= $data['penulis'] ?>" required><br>
  <label>Tahun:</label><input type="number" name="tahun" value="<?= $data['tahun'] ?>" required><br>
  <label>Kategori:</label><input type="text" name="kategori" value="<?= $data['kategori'] ?>" required><br>
  <label>Deskripsi:</label><textarea name="deskripsi" required><?= $data['deskripsi'] ?></textarea><br>
  <input type="submit" name="submit" value="Update">
</form>
<a href="index.php">Kembali</a>
</body>
</html>
<?php
if (isset($_POST['submit'])) {
  $judul = $_POST['judul'];
  $penulis = $_POST['penulis'];
  $tahun = $_POST['tahun'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];
  $query = "UPDATE buku SET judul='$judul', penulis='$penulis', tahun='$tahun', kategori='$kategori', deskripsi='$deskripsi' WHERE id=$id";
  if (mysqli_query($koneksi, $query)) {
    header("Location: index.php");
    exit;
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
}
?>
