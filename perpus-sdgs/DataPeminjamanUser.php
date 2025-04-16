<?php
session_start();
include 'koneksi.php';

// Pastikan pengguna telah login dan memiliki ID pengguna
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "Harap login terlebih dahulu.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Query untuk mengambil data peminjaman buku dari database berdasarkan user_id
$query = "SELECT borrowings.id AS borrowing_id, borrowings.book_id, books.title, borrowings.borrow_date, borrowings.return_date, borrowings.status 
          FROM borrowings 
          JOIN books ON borrowings.book_id = books.id 
          WHERE borrowings.user_id = $user_id";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    echo "Gagal mengambil data peminjaman.";
    exit;
}

if (mysqli_num_rows($result) > 0) {
    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }

    echo json_encode($books);  // Mengembalikan data dalam format JSON
} else {
    echo json_encode([]); // Jika tidak ada peminjaman, kembalikan array kosong
}
?>
