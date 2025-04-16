<?php
include 'koneksi.php';
session_start();

// HANDLE GET REQUEST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        echo json_encode(["error" => "ID tidak ditemukan"]);
        exit;
    }

    $id = intval($_GET['id']);
    $result = mysqli_query($koneksi, "SELECT * FROM books WHERE id = $id");

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Buku tidak ditemukan"]);
    }
    exit;
}

// HANDLE POST REQUEST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = intval($_POST['id']);
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    // Ambil data lama
    $result = mysqli_query($koneksi, "SELECT * FROM books WHERE id = $id");
    $dataLama = mysqli_fetch_assoc($result);
    $coverLama = $dataLama['cover'];

    if (!empty($_FILES['cover']['name'])) {
        $coverBaru = basename($_FILES['cover']['name']);
        $coverPath = "Cover/" . $coverBaru;
        move_uploaded_file($_FILES['cover']['tmp_name'], $coverPath);
    } else {
        $coverBaru = $coverLama;
    }

    $query = "UPDATE books SET 
                judul = '$judul',
                penulis = '$penulis',
                tahun = '$tahun',
                kategori = '$kategori',
                deskripsi = '$deskripsi',
                cover = '$coverBaru'
              WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: DaftarBukuUser.html");
        exit;
    } else {
        echo "Gagal update: " . mysqli_error($koneksi);
    }
}
?>
