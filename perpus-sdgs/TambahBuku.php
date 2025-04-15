<?php
session_start();

// Periksa apakah pengguna sudah login dan admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Jika belum login atau bukan admin, alihkan ke halaman login
    header('Location: login.php');
    exit;
}

echo "<h1>Tambah Buku</h1>";
// Form untuk menambahkan buku
?>
<form action="proses_tambah_buku.php" method="POST" enctype="multipart/form-data">
    <label for="title">Judul Buku:</label>
    <input type="text" name="title" required><br>
    
    <label for="author">Penulis:</label>
    <input type="text" name="author" required><br>
    
    <label for="publisher">Penerbit:</label>
    <input type="text" name="publisher" required><br>
    
    <label for="year">Tahun Terbit:</label>
    <input type="text" name="year" required><br>
    
    <label for="isbn">ISBN:</label>
    <input type="text" name="isbn" required><br>
    
    <label for="category">Kategori:</label>
    <input type="text" name="category" required><br>
    
    <label for="stock">Stok:</label>
    <input type="number" name="stock" required><br>
    
    <label for="cover_image">Cover Buku:</label>
    <input type="file" name="cover_image"><br>
    
    <button type="submit">Tambah Buku</button>
</form>
