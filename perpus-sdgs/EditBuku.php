<?php
session_start();
include 'koneksi.php';

// Jika request GET, ambil data buku berdasarkan ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Buku tidak ditemukan!']);
    }
    exit;
}

// Jika request POST, proses update data buku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = intval($_POST['id']); // ID dikirim melalui form
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $isbn = $_POST['isbn'];
    $kategori = $_POST['kategori'];
    $stock = $_POST['stock'];

    // Ambil data lama terlebih dahulu
    $queryLama = "SELECT cover_image FROM books WHERE id = $id";
    $resultLama = mysqli_query($koneksi, $queryLama);
    $dataLama = mysqli_fetch_assoc($resultLama);
    $coverLama = $dataLama['cover_image'];

    // Cek apakah ada gambar baru yang diupload
    if (!empty($_FILES['cover']['name'])) {
        $coverBaru = basename($_FILES['cover']['name']);
        $coverPath = "Cover/" . $coverBaru;
        move_uploaded_file($_FILES['cover']['tmp_name'], $coverPath);
    } else {
        $coverBaru = $coverLama; // Pakai yang lama
    }

    // Update data ke database
    $query = "UPDATE books SET 
                title = '$judul', 
                author = '$penulis', 
                year = '$tahun', 
                isbn = '$isbn', 
                category = '$kategori', 
                stock = '$stock',
                cover_image = '$coverBaru' 
              WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: DaftarBukuUser.html");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
