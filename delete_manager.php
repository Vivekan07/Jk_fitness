<?php
include 'include/db.php';

try {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('Manager ID is required');
    }

    // Get profile image path before deleting
    $stmt = $pdo->prepare("SELECT profile_image FROM branch_managers WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    $profileImage = $stmt->fetchColumn();

    // Delete manager
    $stmt = $pdo->prepare("DELETE FROM branch_managers WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    // Delete profile image file if exists
    if ($profileImage && file_exists($profileImage)) {
        unlink($profileImage);
    }

    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 