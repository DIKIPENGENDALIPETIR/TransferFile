<?php
require_once 'includes/auth.php';
require_once 'includes/file-upload.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Tambahkan penanganan error
$error = '';
try {
    $files = getUserFiles($_SESSION['user_id']);
} catch (Exception $e) {
    $error = "Terjadi kesalahan saat memuat data file";
    error_log($e->getMessage());
    $files = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - File Transfer System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">File yang Diterima</h1>
            <a href="upload.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                <i class="fas fa-plus mr-2"></i> Kirim File Baru
            </a>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
                <a href="index.php" class="float-right font-semibold">Coba lagi</a>
            </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <?php if (empty($files)): ?>
                <div class="p-6 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                    <p>Tidak ada file yang diterima</p>
                    <a href="upload.php" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                        Kirim file pertama Anda
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($files as $file): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                                            <?= htmlspecialchars($file['sender_email']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <i class="fas fa-file-alt text-gray-400 mr-2"></i>
                                        <?= htmlspecialchars($file['original_name']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <i class="far fa-clock text-gray-400 mr-2"></i>
                                        <?= date('d M Y H:i', strtotime($file['uploaded_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="download.php?id=<?= $file['id'] ?>&key=<?= $file['key_hash'] ?>" 
                                           class="text-blue-500 hover:text-blue-700 transition duration-200">
                                           <i class="fas fa-download mr-1"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>