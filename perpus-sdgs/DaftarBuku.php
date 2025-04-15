<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login
$is_logged_in = isset($_SESSION['username']);
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';  // Misalkan role disimpan di session

$query = "SELECT * FROM books";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='8'>
            <tr>
                <th>Cover</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>ISBN</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $cover = isset($row['cover_image']) && $row['cover_image'] !== '' 
            ? "<img src='Cover/" . htmlspecialchars($row['cover_image']) . "' class='book-cover' alt='Cover Buku'>" 
            : "<img src='path_to_default_image.jpg' class='book-cover' alt='No cover available'>";

        echo "<tr>
                <td>$cover</td>
                <td>" . htmlspecialchars($row['title']) . "</td>
                <td>" . htmlspecialchars($row['author']) . "</td>
                <td>" . htmlspecialchars($row['publisher']) . "</td>
                <td>" . htmlspecialchars($row['year']) . "</td>
                <td>" . htmlspecialchars($row['isbn']) . "</td>
                <td>" . htmlspecialchars($row['category']) . "</td>
                <td>" . htmlspecialchars($row['stock']) . "</td>
              </tr>";
    }
    echo "</table>";

    // Jika pengguna sudah login dan admin, tampilkan link untuk tambah buku
    if ($is_logged_in && $is_admin) {
        echo "<p><a href='tambah_buku.php'>Tambah Buku</a></p>";
    }

} else {
    echo "<p>Tidak ada data buku.</p>";
}

// Jika pengguna belum login, tampilkan pesan yang sesuai
if (!$is_logged_in) {
    echo "<p>Silakan login untuk menambahkan buku.</p>";
}
?>
