<?php
require_once 'includes/auth.php';
require_once 'includes/file-upload.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiverEmail = $_POST['receiver_email'] ?? '';
    $file = $_FILES['file'] ?? null;
    
    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $result = uploadFile($_SESSION['user_id'], $receiverEmail, $file);
        
        if ($result === true) {
            $success = "File berhasil dikirim!";
        } else {
            $error = $result;
        }
    } else {
        $error = "Silakan pilih file yang valid";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File - File Transfer System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Kirim File</h1>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="upload.php" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="receiver_email" class="block text-gray-700 mb-2">Email Penerima</label>
                    <input type="email" id="receiver_email" name="receiver_email" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="file" class="block text-gray-700 mb-2">Pilih File (PDF, JPEG, PNG, TXT - Maks 5MB)</label>
                    <input type="file" id="file" name="file" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           accept=".pdf,.jpg,.jpeg,.png,.txt">
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Kirim File
                </button>
            </form>
        </div>
    </div>
</body>
</html>