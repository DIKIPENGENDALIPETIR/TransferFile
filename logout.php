<?php
require_once 'includes/auth.php';

// Logout pengguna
logout();

// Redirect ke halaman login
header("Location: login.php");
exit();
?>