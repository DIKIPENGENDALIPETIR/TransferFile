<?php
// includes/file-upload.php
require_once 'config.php';
require_once 'security.php';

function generateKeyHash() {
    return bin2hex(random_bytes(32));
}

function uploadFile($senderId, $receiverEmail, $file) {
    global $pdo;
    
    // Validasi penerima
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$receiverEmail]);
    $receiver = $stmt->fetch();
    
    if (!$receiver) {
        return "Penerima tidak ditemukan";
    }
    
    $receiverId = $receiver['id'];
    
    // Validasi file
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'text/plain'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowedTypes)) {
        return "Format file tidak diizinkan. Hanya PDF, JPEG, PNG, dan TXT yang diperbolehkan.";
    }
    
    if ($file['size'] > $maxSize) {
        return "Ukuran file terlalu besar. Maksimal 5MB.";
    }
    
    // Generate nama file unik
    $originalName = sanitizeFilename(basename($file['name']));
    $fileExt = pathinfo($originalName, PATHINFO_EXTENSION);
    $newFilename = uniqid() . '.' . $fileExt;
    $uploadPath = 'assets/uploads/' . $newFilename;
    
    // Generate key hash untuk keamanan
    $keyHash = generateKeyHash();
    
    // Pindahkan file ke folder uploads
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Simpan ke database - pastikan nama tabel benar
        $stmt = $pdo->prepare("INSERT INTO transferfile (sender_id, receiver_id, original_name, file_path, key_hash) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$senderId, $receiverId, $originalName, $uploadPath, $keyHash]);
        
        return true;
    }
    
    return "Gagal mengupload file";
}

function getUserFiles($userId) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            SELECT tf.*, u.email as sender_email 
            FROM transferfile tf
            JOIN users u ON tf.sender_id = u.id
            WHERE tf.receiver_id = ?
            ORDER BY tf.uploaded_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}

// ... other functions if any ...