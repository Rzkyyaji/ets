<?php
session_start();
if (isset($_SESSION['role'])) {
    echo $_SESSION['role']; // Akan mengembalikan 'admin' atau 'anggota'
} else {
    echo 'guest';
}
?>
