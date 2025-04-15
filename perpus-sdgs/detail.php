<?php include 'koneksi.php';
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = $id");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head><title>Detail Buku</title><link rel="stylesheet" href="style/main.css"></head>
<body>
<h2>Detail Buku</h2>
<p><strong>Judul:</strong> <?= $data['judul'] ?></p>
<p><strong>Penulis:</strong> <?= $data['penulis'] ?></p>
<p><strong>Tahun:</strong> <?= $data['tahun'] ?></p>
<p><strong>Kategori:</strong> <?= $data['kategori'] ?></p>
<p><strong>Deskripsi:</strong> <?= $data['deskripsi'] ?></p>
<a href="index.php">Kembali</a>
</body>
</html>
