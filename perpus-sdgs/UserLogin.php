<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];

    // Cari user berdasarkan email
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan data ke sesi
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];

            // Redirect ke homepage_user
            header("Location: homepage_user.html");
            exit();
        } else {
            echo "Password salah!";
            echo "<script>
            setTimeout(function() {
                window.location.href = 'UserLogin.html';
            }, 2000); // 2000 milidetik = 2 detik
        </script>";
        }
    } else {
        echo "Email tidak ditemukan!";
    }
} else {
    echo "Akses tidak valid!";
}
?>
