<?php
// includes/auth.php
require_once 'config.php';
require_once 'security.php';

function registerUser($email, $password) {
    global $pdo;
    
    // Validasi input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Format email tidak valid";
    }
    
    if (strlen($password) < 8) {
        return "Password minimal 8 karakter";
    }
    
    // Cek apakah email sudah terdaftar
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        return "Email sudah terdaftar";
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $hashedPassword]);
    
    return true;
}

function loginUser($email, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        return true;
    }
    
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logout() {
    session_unset();
    session_destroy();
}
?>