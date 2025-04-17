<?php
include 'koneksi.php';

$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';
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
                <th>Stock</th>
                <th>Aksi</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $coverPath = "Cover/" . htmlspecialchars($row['cover_image']);
        $cover = (!empty($row['cover_image']) && file_exists($coverPath))
            ? "<img src='$coverPath' width='80' height='100'>"
            : "Tidak ada cover";

        echo "<tr>
            <td>{$row['id']}</td>
            <td>$cover</td>
            <td>{$row['title']}</td>
            <td>{$row['author']}</td>
            <td>{$row['publisher']}</td>
            <td>{$row['year']}</td>
            <td>{$row['isbn']}</td>
            <td>{$row['category']}</td>
            <td>{$row['stock']}</td>
            <td><a href='detail.php?id={$row['id']}'>Detail</a></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ditemukan hasil yang cocok.</p>";
}
?>
