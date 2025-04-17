<?php
session_start();
include 'koneksi.php';

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$isUser  = isset($_SESSION['role']) && $_SESSION['role'] === 'anggota';
$isGuest = !$isAdmin && !$isUser;

$keyword  = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';
$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : '';

$query = "SELECT * FROM books WHERE 1=1";

if (!empty($keyword)) {
    $query .= " AND (title LIKE '%$keyword%' OR author LIKE '%$keyword%')";
}

if (!empty($kategori)) {
    $query .= " AND category = '$kategori'";
}

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
    
    // Tambahkan kolom aksi hanya jika role adalah user
    if ($isUser) {
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

        // Jika user biasa (anggota), tampilkan tombol pinjam
        if ($isUser) {
            echo "<td><a href='Peminjaman.php?id=" . $row['id'] . "'>Pinjam</a></td>";
        }

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Tidak ditemukan hasil yang cocok.</p>";
}
?>
