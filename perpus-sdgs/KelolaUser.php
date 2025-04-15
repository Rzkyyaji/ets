<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}
include '../config/koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM users");

echo "<h2>Daftar Pengguna</h2>";
echo "<table border='1'>
<tr><th>Username</th><th>Email</th><th>Role</th><th>Aksi</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['email']}</td>
        <td>{$row['role']}</td>
        <td>
            <a href='hapus_user.php?id={$row['id']}' onclick=\"return confirm('Hapus user ini?')\">Hapus</a>
        </td>
    </tr>";
}
echo "</table>";
?>
