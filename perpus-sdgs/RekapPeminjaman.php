<?php
session_start();
include 'koneksi.php';

header('Content-Type: application/json');

// Cek login dan role admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Akses ditolak. Halaman ini hanya untuk admin.']);
    exit;
}

// Ambil data peminjaman
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT borrowings.id AS borrowing_id, borrowings.book_id, books.title, users.name, 
                     borrowings.borrow_date, borrowings.return_date, borrowings.status 
              FROM borrowings 
              JOIN books ON borrowings.book_id = books.id 
              JOIN users ON borrowings.user_id = users.id";

    $result = mysqli_query($koneksi, $query);
    $data = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Query gagal: ' . mysqli_error($koneksi)]);
    }
    exit;
}

// Proses pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $book_id = intval($_POST['book_id']);
    $today = date('Y-m-d');

    // Ambil stok buku saat ini
    $query = "SELECT stock FROM books WHERE id = $book_id";
    $result = mysqli_query($koneksi, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_stock = $row['stock'];

        // Tambah stok buku
        $new_stock = $current_stock + 1;

        // Update stok buku di tabel books
        $update_stock_query = "UPDATE books SET stock = $new_stock WHERE id = $book_id";
        if (mysqli_query($koneksi, $update_stock_query)) {
            // Update status peminjaman menjadi 'Dikembalikan'
            $update_borrowing_query = "UPDATE borrowings 
                                       SET status='Dikembalikan', return_date='$today' 
                                       WHERE id = $id AND book_id = $book_id";

            if (mysqli_query($koneksi, $update_borrowing_query)) {
                echo json_encode(['message' => 'Buku berhasil dikembalikan dan stok diperbarui.']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Gagal mengupdate status peminjaman.']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Gagal mengupdate stok buku.']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Buku tidak ditemukan.']);
    }

    exit;
}
?>
