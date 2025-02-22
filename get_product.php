<?php
include 'include/db.php';

try {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('Product ID is required');
    }

    $productId = $_POST['id'];

    // Get product details
    $stmt = $pdo->prepare("
        SELECT p.*, GROUP_CONCAT(pi.id) as image_ids, GROUP_CONCAT(pi.image_path) as image_paths 
        FROM products p 
        LEFT JOIN product_images pi ON p.id = pi.product_id 
        WHERE p.id = ?
        GROUP BY p.id
    ");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception('Product not found');
    }

    // Format images array
    $images = [];
    if ($product['image_ids']) {
        $imageIds = explode(',', $product['image_ids']);
        $imagePaths = explode(',', $product['image_paths']);
        for ($i = 0; $i < count($imageIds); $i++) {
            $images[] = [
                'id' => $imageIds[$i],
                'path' => $imagePaths[$i]
            ];
        }
    }

    // Remove the concatenated image fields and add formatted images array
    unset($product['image_ids']);
    unset($product['image_paths']);
    $product['images'] = $images;

    echo json_encode($product);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 