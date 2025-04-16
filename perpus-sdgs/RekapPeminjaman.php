<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo "Akses ditolak.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrow_id = intval($_POST['id']);
    $book_id = intval($_POST['book_id']);

    // Update status borrowings menjadi 'dikembalikan'
    $updateStatus = mysqli_query($koneksi, "UPDATE borrowings SET status = 'dikembalikan', actual_return_date = CURDATE() WHERE id = $borrow_id");

    if ($updateStatus) {
        // Tambah stok buku
        $updateStock = mysqli_query($koneksi, "UPDATE books SET stock = stock + 1 WHERE id = $book_id");

        if ($updateStock) {
            echo "Buku berhasil dikembalikan dan stok diperbarui.";
        } else {
            echo "Gagal memperbarui stok buku.";
        }
    } else {
        echo "Gagal memperbarui status peminjaman.";
    }
    exit;
}

$query = "SELECT borrowings.id AS borrowing_id, borrowings.book_id, users.name, books.title, borrowings.borrow_date, borrowings.return_date 
          FROM borrowings 
          JOIN users ON borrowings.user_id = users.id 
          JOIN books ON borrowings.book_id = books.id 
          WHERE borrowings.status = 'dipinjam'";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    echo "<p>Gagal mengambil data peminjaman.</p>";
    exit;
}

// Jika tidak ada data peminjaman
if (mysqli_num_rows($result) == 0) {
    // Arahkan ke halaman DaftarBukuUser.html jika tidak ada data peminjaman
    header("Location: DaftarBukuUser.html");
    exit;
}

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='8'>
            <tr>
                <th>ID</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['borrowing_id']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['title']) . "</td>
                <td>" . htmlspecialchars($row['borrow_date']) . "</td>
                <td>" . htmlspecialchars($row['return_date']) . "</td>
                <td><button class='btn-kembali' data-id='" . $row['borrowing_id'] . "' data-book-id='" . $row['book_id'] . "'>Kembalikan</button></td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>Belum ada data peminjaman.</p>";
}
?>
