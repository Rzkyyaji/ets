<?php
session_start();
include 'koneksi.php';

// Cek apakah email sudah ada di session
if (!isset($_SESSION['email'])) {
    echo "Anda belum login.";
    exit();
}

$sessionEmail = $_SESSION['email']; // <- INI PENTING ADA DI SINI
$formEmail    = $_POST['email'] ?? ''; // aman dari warning jika tidak ada

// Pastikan email dari session dan form cocok
if ($sessionEmail !== $formEmail) {
    echo "Email di form tidak cocok dengan session.";
    exit();
}

// Ambil data input dari form
$nameBaru     = $_POST['username'] ?? '';
$passwordLama = $_POST['old_password'] ?? '';
$passwordBaru = $_POST['new_password'] ?? '';

// Query ambil data user
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$sessionEmail'");
$data  = mysqli_fetch_assoc($query);

// Cek data user ada
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

// Update data user
$update = mysqli_query($koneksi, "
    UPDATE users 
    SET 
        name = '$nameBaru', 
        password = '$passwordBaruHash' 
    WHERE 
        email = '$sessionEmail'
");

if ($update) {
    echo "Profil berhasil diperbarui.";
} else {
    echo "Gagal memperbarui profil.";
}

if ($update) {
    echo "Profil berhasil diperbarui. Anda akan diarahkan kembali ke homepage...";

    // Tambahkan JavaScript untuk redirect otomatis
    echo "<script>
        setTimeout(function() {
            window.location.href = 'homepage_user.html';
        }, 2000); // 2000 milidetik = 2 detik
    </script>";
} else {
    echo "Gagal memperbarui profil.";
}
?>
