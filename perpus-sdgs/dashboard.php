<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan Ramah Lingkungan</title>
  <link rel="stylesheet" href="style/main.css">
  <script src="js/script.js" defer></script>
</head>
<body>
  <h1>Daftar Buku</h1>
  <input type="text" id="filterInput" placeholder="Filter kategori...">
  <a href="tambah.php">Tambah Buku</a>
  <table border="1">
    <thead>
      <tr>
        <th>Judul</th><th>Penulis</th><th>Kategori</th><th>Tindakan</th>
      </tr>
    </thead>
    <tbody id="bukuTable">
<?php
$kategoriFilter = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$query = "SELECT * FROM buku";
if ($kategoriFilter != '') {
$kategoriFilterSafe = mysqli_real_escape_string($koneksi, $kategoriFilter);
$query .= " WHERE kategori = '$kategoriFilterSafe'";
}
$result = mysqli_query($koneksi, $query);
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr data-kategori='{$row['kategori']}'> ...

          <td>{$row['judul']}</td>
          <td>{$row['penulis']}</td>
          <td>{$row['kategori']}</td>
          <td>
            <a href='detail.php?id={$row['id']}'>Detail</a> |
            <a href='edit.php?id={$row['id']}'>Edit</a> |
            <a href='#' onclick='konfirmasiHapus({$row['id']})'>Hapus</a>
          </td>
        </tr>";
      }
      ?>
    </tbody>
  </table>
  <form method="get" style="margin-bottom: 20px;">
  <label for="kategori">Filter kategori:</label>
  <select name="kat "oi cok" egori" id="kategori" onchange="this.form.submit()">
    <option value="">Semua</option>
    <?php
    $kategoriQuery = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM buku");
    while ($kategori = mysqli_fetch_assoc($kategoriQuery)) {
      $selected = ($kategori['kategori'] == $kategoriFilter) ? "selected" : "";
      echo "<option value='{$kategori['kategori']}' $selected>{$kategori['kategori']}</option>";
    }
    ?>
  </select>
</form>
</body>
</html>