<?php
// includes/security.php

// Fungsi untuk membersihkan input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Fungsi untuk generate CSRF token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Validasi CSRF token
function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Fungsi untuk memeriksa brute force attack
function checkBruteForce($email, $pdo) {
    $now = time();
    $valid_attempts = $now - (2 * 60 * 60); // 2 jam terakhir
    
    // Perbaikan: Gunakan tabel login_attempts, bukan transferfile
    $stmt = $pdo->prepare("SELECT time FROM login_attempts 
                          WHERE email = ? AND time > ?");
    $stmt->execute([$email, $valid_attempts]);
    
    return ($stmt->rowCount() > 5); // Jika lebih dari 5 percobaan gagal
}

// Fungsi untuk mencatat percobaan login gagal
function recordLoginAttempt($email, $pdo) {
    // Perbaikan: Gunakan tabel login_attempts, bukan transferfile
    $stmt = $pdo->prepare("INSERT INTO login_attempts (email, time) VALUES (?, ?)");
    $stmt->execute([$email, time()]);
}

// Fungsi untuk mengamankan nama file
function sanitizeFilename($filename) {
    $filename = preg_replace("/[^a-zA-Z0-9_.-]/", "", $filename);
    return substr($filename, 0, 100); // Batasi panjang nama file
}

// Fungsi untuk validasi email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
?>