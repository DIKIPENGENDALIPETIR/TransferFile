<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/security.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    // Validasi CSRF token
    if (!validateCsrfToken($csrf_token)) {
        $error = "Invalid CSRF token";
    } 
    // Validasi input
    elseif (empty($email) || empty($password)) {
        $error = "Email dan password harus diisi";
    } 
    // Cek brute force
    elseif (checkBruteForce($email, $pdo)) {
        $error = "Terlalu banyak percobaan login. Silakan coba lagi nanti.";
    } 
    // Proses login
    else {
        if (loginUser($email, $password)) {
            // Reset login attempts on success
            $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE email = ?");
            $stmt->execute([$email]);
            
            header("Location: index.php");
            exit();
        } else {
            // Catat percobaan gagal
            recordLoginAttempt($email, $pdo);
            $error = "Email atau password salah";
        }
    }
}

$csrf_token = generateCsrfToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Secure File Transfer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <div class="text-center mb-6">
                <i class="fas fa-lock text-4xl text-blue-500 mb-2"></i>
                <h1 class="text-2xl font-bold">Login ke Sistem</h1>
            </div>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div>
                    <label for="email" class="block text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                        <input type="email" id="email" name="email" required 
                               class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="email@contoh.com">
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input type="password" id="password" name="password" required 
                               class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="••••••••">
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                    </div>
                    <a href="forgot-password.php" class="text-sm text-blue-500 hover:text-blue-700">Lupa password?</a>
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>
            
            <div class="mt-4 text-center text-sm">
                <p class="text-gray-600">Belum punya akun? 
                    <a href="register.php" class="text-blue-500 hover:text-blue-700 font-medium">Daftar disini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>