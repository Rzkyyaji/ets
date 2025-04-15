<?php
session_start();
include 'koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judul = htmlspecialchars($_POST["judul"]);
    $penulis = htmlspecialchars($_POST["penulis"]);
    $penerbit = htmlspecialchars($_POST["penerbit"]);
    $tahun_terbit = intval($_POST["tahun_terbit"]);

    $cover = null;
    if (isset($_FILES["cover"]) && $_FILES["cover"]["error"] == 0) {
        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder);
        }
        $namaFile = uniqid() . "_" . basename($_FILES["cover"]["name"]);
        $tujuan = $folder . $namaFile;
        if (move_uploaded_file($_FILES["cover"]["tmp_name"], $tujuan)) {
            $cover = $namaFile;
        }
    }

    $query = "INSERT INTO books (judul, penulis, penerbit, tahun_terbit, cover) 
              VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$cover')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: DaftarBuku.html");
    } else {
        echo "Gagal menambahkan buku: " . mysqli_error($koneksi);
    }
}
?>
