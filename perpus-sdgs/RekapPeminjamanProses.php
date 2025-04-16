<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak.";
    exit();
}

$borrow_id = intval($_POST['borrow_id']);
$book_id = intval($_POST['book_id']);

// Tambahkan stok buku
mysqli_query($koneksi, "UPDATE books SET stock = stock + 1 WHERE id = $book_id");

// Hapus data dari borrowings
$delete = mysqli_query($koneksi, "DELETE FROM borrowings WHERE id = $borrow_id");

if ($delete) {
    echo "Buku berhasil dikembalikan dan data dihapus.";
} else {
    echo "Gagal menghapus data.";
}
?>
