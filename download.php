<?php
require_once 'includes/auth.php';
require_once 'includes/config.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$fileId = $_GET['id'] ?? 0;
$keyHash = $_GET['key'] ?? '';

// Validasi akses file
$stmt = $pdo->prepare("
    SELECT * FROM transferfile 
    WHERE id = ? AND key_hash = ? AND receiver_id = ?
");
$stmt->execute([$fileId, $keyHash, $_SESSION['user_id']]);
$file = $stmt->fetch();

if (!$file || !file_exists($file['file_path'])) {
    die("File tidak ditemukan atau Anda tidak memiliki akses");
}

// Set header untuk download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file['original_name']) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file['file_path']));
readfile($file['file_path']);
exit;
?>