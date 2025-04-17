<?php
session_start();
include 'koneksi.php';

// Cek role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo "Akses ditolak. Halaman ini hanya untuk admin.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = intval($_POST['tahun']);
    $isbn = $_POST['isbn'];
    $kategori = $_POST['kategori'];
    $stok = intval($_POST['stok']);

    // Proses file cover
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $coverName = basename($_FILES['cover']['name']);
$coverTmp = $_FILES['cover']['tmp_name'];
$coverPath = 'Cover/' . $coverName;

// Cek folder Cover
if (!is_dir('Cover')) {
    mkdir('Cover', 0777, true);
}

if (move_uploaded_file($coverTmp, $coverPath)) {
    $query = "INSERT INTO books (title, author, publisher, year, isbn, category, stock, cover_image) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'sssissis', $judul, $penulis, $penerbit, $tahun, $isbn, $kategori, $stok, $coverName);

    if (mysqli_stmt_execute($stmt)) {
        echo "Buku berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan buku.";
    }
} else {
    echo "Gagal mengunggah gambar.";
}
    } else {
        echo "File cover tidak valid.";
    }
}
?>
