<?php
include 'include/db.php';

try {
    if (!isset($_POST['image_id']) || empty($_POST['image_id'])) {
        throw new Exception('Image ID is required');
    }

    $imageId = $_POST['image_id'];

    // Get image path before deleting
    $stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE id = ?");
    $stmt->execute([$imageId]);
    $imagePath = $stmt->fetchColumn();

    if ($imagePath && file_exists($imagePath)) {
        unlink($imagePath); // Delete physical file
    }

    // Delete from database
    $stmt = $pdo->prepare("DELETE FROM product_images WHERE id = ?");
    $stmt->execute([$imageId]);

    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 