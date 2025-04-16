<?php
session_start();

if (isset($_SESSION['role'])) {
    echo $_SESSION['role'];
} else {
    echo 'guest'; // default jika belum login
}
?>
