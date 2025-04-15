<?php
session_start();
include 'koneksi.php'; // file koneksi ke database

// Pastikan user sudah login
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Pastikan data form (email) ada
if (!isset($_POST['email'])) {
    echo "Email tidak ditemukan di form. Pastikan form terisi dengan benar.";
    exit();
}

$sessionEmail = $_SESSION['email']; // email dari session
$formEmail    = $_POST['email'];    // email dari form read-only

// Pastikan email di form sama dengan email session
if ($sessionEmail !== $formEmail) {
    echo "Email di form tidak sesuai dengan email login.";
    exit();
}

// Ambil data lain dari form
$usernameBaru = $_POST['username'];
$passwordLama = $_POST['old_password'];
$passwordBaru = $_POST['new_password'];

// Ambil data user lama dari DB berdasarkan session email
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$sessionEmail'");
$data = mysqli_fetch_assoc($query);

// Cek apakah user benar-benar ada di database
if (!$data) {
    echo "Email tidak ditemukan di database.";
    exit();
}

// Verifikasi password lama
if (!password_verify($passwordLama, $data['password'])) {
    echo "Password lama salah!";
    exit();
}

// Hash password baru
$passwordBaruHash = password_hash($passwordBaru, PASSWORD_DEFAULT);

// Update username dan password
$update = mysqli_query($conn, "
    UPDATE users 
    SET 
        username = '$usernameBaru', 
        password = '$passwordBaruHash' 
    WHERE 
        email = '$sessionEmail'
");

if ($update) {
    echo "Profil berhasil diperbarui.";
} else {
    echo "Gagal memperbarui profil.";
}
?>
