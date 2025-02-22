<?php
include 'include/db.php';

try {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('Admin ID is required');
    }

    $stmt = $pdo->prepare("SELECT id, username, nic, profile_image FROM admins WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        throw new Exception('Admin not found');
    }

    echo json_encode($admin);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 