<?php
include 'include/db.php';

try {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('Branch ID is required');
    }

    $stmt = $pdo->prepare("DELETE FROM branches WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 