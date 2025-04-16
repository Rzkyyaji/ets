<?php
session_start();
include 'koneksi.php';

// Ambil ID dari query string
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Memastikan ID adalah angka
} else {
    echo "ID tidak ditemukan!";
    exit;
}

// Query untuk mengambil data buku berdasarkan ID
$query = "SELECT * FROM books WHERE id = $id";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result); // Ambil data buku dari database
} else {
    echo "Buku tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="styleDaftarBuku.css">
</head>
<body>
    <h2>Edit Buku</h2>
    <form method="POST" action="EditBuku.php" enctype="multipart/form-data">
        <!-- Form input dengan data lama diisi otomatis -->
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label>Judul:</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($data['title']) ?>" required><br>

        <label>Penulis:</label>
        <input type="text" name="penulis" value="<?= htmlspecialchars($data['author']) ?>" required><br>

        <label>Penerbit:</label>
        <input type="text" name="penerbit" value="<?= htmlspecialchars($data['publisher']) ?>" required><br>

        <label>Tahun:</label>
        <input type="number" name="tahun" value="<?= htmlspecialchars($data['year']) ?>" required><br>

        <label>ISBN:</label>
        <input type="text" name="isbn" value="<?= htmlspecialchars($data['isbn']) ?>" required><br>

        <label>Kategori:</label>
        <input type="text" name="kategori" value="<?= htmlspecialchars($data['category']) ?>" required><br>

        <label>Deskripsi:</label>
        <textarea name="deskripsi" required><?= htmlspecialchars($data['description']) ?></textarea><br>

        <label>Cover:</label>
        <input type="file" name="cover"><br>

        <button type="submit" name="submit">Update</button>
    </form>

    <a href="DaftarBukuUser.html">Kembali ke Daftar Buku</a>
</body>
</html>

<?php
// Update data setelah form disubmit
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $isbn = $_POST['isbn'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
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

    // Query untuk memperbarui data buku
    $query = "UPDATE books SET 
                title = '$judul', 
                author = '$penulis', 
                publisher = '$penerbit', 
                year = '$tahun', 
                isbn = '$isbn', 
                category = '$kategori', 
                description = '$deskripsi', 
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
