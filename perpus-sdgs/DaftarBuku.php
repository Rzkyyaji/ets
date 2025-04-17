<?php
session_start();
include 'koneksi.php';

// Cek role dari session
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$isUser  = isset($_SESSION['role']) && $_SESSION['role'] === 'anggota';
$isGuest = !$isAdmin && !$isUser; // Belum login

$query = "SELECT * FROM books";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='8'>
            <tr>
                <th>ID</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>ISBN</th>
                <th>Kategori</th>
                <th>Stock</th>";

    // Kolom aksi hanya jika login
    if (!$isGuest) {
        echo "<th>Aksi</th>";
    }

    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $coverPath = "Cover/" . htmlspecialchars($row['cover_image']);
        $cover = (!empty($row['cover_image']) && file_exists($coverPath))
            ? "<img src='$coverPath' width='80' height='100'>"
            : "Tidak ada cover";

        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>$cover</td>
                <td>" . htmlspecialchars($row['title']) . "</td>
                <td>" . htmlspecialchars($row['author']) . "</td>
                <td>" . htmlspecialchars($row['publisher']) . "</td>
                <td>" . htmlspecialchars($row['year']) . "</td>
                <td>" . htmlspecialchars($row['isbn']) . "</td>
                <td>" . htmlspecialchars($row['category']) . "</td>
                <td>" . htmlspecialchars($row['stock']) . "</td>";

        // Aksi hanya untuk yang login
        if (!$isGuest) {
            if ($isAdmin) {
                echo "<td><a href='EditBuku.html?id=" . $row['id'] . "'>Edit</a></td>";
            } elseif ($isUser) {
                echo "<td><a href='Peminjaman.php?id=" . $row['id'] . "'>Pinjam</a></td>";
            }
        }

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Tidak ada data buku.</p>";
}
?>
