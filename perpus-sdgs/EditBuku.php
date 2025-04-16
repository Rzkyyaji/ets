<?php
session_start();
include 'koneksi.php';

// Ambil ID dari query string
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Memastikan ID adalah angka
} else {
    echo json_encode(['error' => 'ID tidak ditemukan!']);
    exit;
}

// Query untuk mengambil data buku berdasarkan ID
$query = "SELECT * FROM books WHERE id = $id";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result); // Ambil data buku dari database
    // Mengirimkan data buku dalam format JSON
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Buku tidak ditemukan!']);
    exit;
}

if (isset($_POST['submit'])) {
  $judul = $_POST['judul'];
  $penulis = $_POST['penulis'];
  $tahun = $_POST['tahun'];
  $isbn = $_POST['isbn'];
  $kategori = $_POST['kategori'];
  $stock = $_POST['stock'];
  $id = $_POST['id'];

  // Cek apakah ada gambar baru yang diupload
  if (!empty($_FILES['cover']['name'])) {
      $coverBaru = basename($_FILES['cover']['name']);
      $coverPath = "Cover/" . $coverBaru;
      move_uploaded_file($_FILES['cover']['tmp_name'], $coverPath);
  } else {
      // Gunakan cover lama jika tidak ada file baru
      $coverBaru = $data['cover_image'];
  }

  // Perbaiki query untuk update data buku (hilangkan deskripsi)
  $query = "UPDATE books SET 
              title = '$judul', 
              author = '$penulis', 
              publisher = '$penerbit', 
              year = '$tahun', 
              isbn = '$isbn', 
              category = '$kategori', 
              stock = '$stock',
              cover_image = '$coverBaru' 
            WHERE id = $id";

  if (mysqli_query($koneksi, $query)) {
      echo "<p>Data buku berhasil diperbarui!</p>";
      header("Location: DaftarBukuUser.html");
      exit;
  } else {
      echo "Error: " . mysqli_error($koneksi);
  }
}
?>
