<?php
session_start();
include 'koneksi.php';

$id = $_POST['id'];
$name = htmlspecialchars($_POST['name']);
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($query);

if ($user && password_verify($old_password, $user['password'])) {
    $updateFields = "name='$name'";
    if (!empty($new_password)) {
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        $updateFields .= ", password='$hashedPassword'";
    }

    $update = mysqli_query($conn, "UPDATE users SET $updateFields, updated_at=NOW() WHERE id='$id'");
    if ($update) {
        $_SESSION['user']['name'] = $name;
        echo "<script>alert('Profil berhasil diperbarui'); window.location='homepage.html';</script>";
    } else {
        echo "Gagal memperbarui profil.";
    }
} else {
    echo "<script>alert('Password lama salah'); window.history.back();</script>";
}
