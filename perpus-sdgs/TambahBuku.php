<?php
include 'koneksi.php';

// Cek apakah data dikirim lewat POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $isbn = $_POST['isbn'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    // Upload cover
    $cover_name = $_FILES['cover']['name'];
    $cover_tmp = $_FILES['cover']['tmp_name'];
    $ext = pathinfo($cover_name, PATHINFO_EXTENSION);
    $nama_baru = uniqid('cover_', true) . '.' . $ext;
    $upload_path = 'Cover/' . $nama_baru;

    if (!move_uploaded_file($cover_tmp, $upload_path)) {
        echo json_encode(['error' => 'Upload cover gagal.']);
        exit;
    }

    // Cari ID kosong (gap)
    $sql_gap = "SELECT t1.id + 1 AS next_id
                FROM books t1
                LEFT JOIN books t2 ON t1.id + 1 = t2.id
                WHERE t2.id IS NULL
                ORDER BY t1.id
                LIMIT 1";

    $result = mysqli_query($koneksi, $sql_gap);
    $id_baru = null;

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_baru = $row['next_id'];
    }

    // Jika tidak ada ID kosong, biarkan NULL (auto_increment)
    if ($id_baru) {
        $stmt = $koneksi->prepare("INSERT INTO books (id, title, author, publisher, year, isbn, category, stock, cover_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssis", $id_baru, $judul, $penulis, $penerbit, $tahun, $isbn, $kategori, $stok, $nama_baru);
    } else {
        $stmt = $koneksi->prepare("INSERT INTO books (title, author, publisher, year, isbn, category, stock, cover_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssis", $judul, $penulis, $penerbit, $tahun, $isbn, $kategori, $stok, $nama_baru);
    }

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Buku berhasil ditambahkan.']);
    } else {
        echo json_encode(['error' => 'Gagal menambahkan buku: ' . $stmt->error]);
    }
}
?>
