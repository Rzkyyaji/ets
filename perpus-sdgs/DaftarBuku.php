<?php
session_start();
include 'koneksi.php';

// Memeriksa apakah user sudah login dan apakah role-nya adalah admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

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
                <th>Stok</th>";

    // Tambahkan kolom "Edit" jika user adalah admin
    if ($isAdmin) {
        echo "<th>Actions</th>";
    }

    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $coverPath = "Cover/" . htmlspecialchars($row['cover_image']);
        $cover = (!empty($row['cover_image']) && file_exists($coverPath))
            ? "<img src='$coverPath' width='80' height='100'>"
            : "Tidak ada cover";

        echo "<tr>
                <td>$cover</td>
                <td>" . htmlspecialchars($row['title']) . "</td>
                <td>" . htmlspecialchars($row['author']) . "</td>
                <td>" . htmlspecialchars($row['publisher']) . "</td>
                <td>" . htmlspecialchars($row['year']) . "</td>
                <td>" . htmlspecialchars($row['isbn']) . "</td>
                <td>" . htmlspecialchars($row['category']) . "</td>
                <td>" . htmlspecialchars($row['stock']) . "</td>";

        // Menampilkan tombol edit hanya jika user adalah admin
        if ($isAdmin) {
            echo "<td><a href='editBuku.php?id=" . $row['id'] . "'>Edit</a></td>";
        }

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Tidak ada data buku.</p>";
}
?>
