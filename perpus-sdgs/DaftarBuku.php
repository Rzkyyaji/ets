<?php
session_start();
include 'koneksi.php';

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
        $cover = isset($row['cover']) && $row['cover'] !== ''
            ? "<img src='Cover/" . htmlspecialchars($row['cover']) . "' width='80' height='100'>"
            : "Tidak ada cover";

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
} else {
    echo "<p>Tidak ada data buku.</p>";
}
?>
