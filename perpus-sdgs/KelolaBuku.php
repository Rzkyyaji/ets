<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}
include '../config/koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM books");

echo "<h2>Daftar Buku</h2>";
echo "<a href='tambah_buku.php'>+ Tambah Buku</a><br><br>";
echo "<table border='1'>
<tr><th>Judul</th><th>Penulis</th><th>Aksi</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['title']}</td>
        <td>{$row['author']}</td>
        <td>
            <a href='edit_buku.php?id={$row['id']}'>Edit</a> | 
            <a href='hapus_buku.php?id={$row['id']}' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
        </td>
    </tr>";
}
echo "</table>";
?>
