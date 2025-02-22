<?php
include 'include/db.php';

try {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('Product ID is required');
    }

    $productId = $_POST['id'];

    // Start transaction
    $pdo->beginTransaction();

    // Get image paths to delete files
    $stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
    $stmt->execute([$productId]);
    $images = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Delete product (will cascade to product_images due to foreign key)
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$productId]);

    // Delete physical image files
    foreach ($images as $imagePath) {
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 