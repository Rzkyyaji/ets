<?php
session_start();
session_destroy();  // Hapus seluruh data sesi
header('Location: UserLogin.html');  // Redirect ke halaman login
exit;

?>