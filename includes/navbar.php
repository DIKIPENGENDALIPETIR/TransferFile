<nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="index.php" class="text-xl font-bold text-blue-600">FileTransfer</a>
        
        <div class="flex items-center space-x-4">
            <?php if (isLoggedIn()): ?>
                <span class="text-gray-600"><?= htmlspecialchars($_SESSION['user_email']) ?></span>
                <a href="upload.php" class="text-blue-500 hover:text-blue-700">Kirim File</a>
                <a href="logout.php" class="text-red-500 hover:text-red-700">Logout</a>
            <?php else: ?>
                <a href="login.php" class="text-blue-500 hover:text-blue-700">Login</a>
                <a href="register.php" class="text-blue-500 hover:text-blue-700">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>