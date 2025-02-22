<?php
include 'include/db.php';

try {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('Manager ID is required');
    }

    $stmt = $pdo->prepare("SELECT id, username, phone, nic, address, profile_image FROM branch_managers WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    $manager = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$manager) {
        throw new Exception('Manager not found');
    }

    echo json_encode($manager);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 