<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'anggota') {
    echo "<script>alert('Akses ditolak.'); window.location.href='DaftarBukuUser.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_GET['id']);

// Ambil detail buku
$query = "SELECT * FROM books WHERE id = $book_id";
$result = mysqli_query($koneksi, $query);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    echo "<script>alert('Buku tidak ditemukan.'); window.location.href='homepage_user.html';</script>";
    exit();
}

if ($book['stock'] <= 0) {
    echo "<script>alert('Stok buku habis.'); window.location.href='homepage_user.html';</script>";
    exit();
}

// Kurangi stok buku
mysqli_query($koneksi, "UPDATE books SET stock = stock - 1 WHERE id = $book_id");

// Tambahkan ke peminjaman
$tanggalPinjam = date('Y-m-d');
mysqli_query($koneksi, "INSERT INTO borrowings (user_id, book_id, borrow_date, status)
                        VALUES ($user_id, $book_id, '$tanggalPinjam', 'dipinjam')");

// Pop up konfirmasi
$judul = htmlspecialchars($book['title']);
$penulis = htmlspecialchars($book['author']);

echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Buku berhasil dipinjam.\\nJudul: $judul\\nPenulis: $penulis',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'DaftarBukuUser.html';
        });
    });
</script>";
?>
