<?php
session_start();
session_destroy();  // Hapus session
header('Location: beranda.php');  // Redirect ke halaman login
exit();
?>
