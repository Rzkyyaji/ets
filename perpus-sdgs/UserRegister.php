<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Amankan password
    $role = "anggota"; // default role sesuai enum di database

    // Cek apakah email sudah terdaftar
    $check = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "Email sudah terdaftar!";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($koneksi, $sql)) {
            echo "Registrasi berhasil! <a href='UserLogin.html'>Login sekarang</a>";
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($koneksi);
        }
    }
} else {
    echo "Akses tidak valid!";
}
?>
