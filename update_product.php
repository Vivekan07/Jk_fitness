<?php
include 'include/db.php';

try {
    if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
        throw new Exception('Product ID is required');
    }

    $pdo->beginTransaction();

    // Update product details
    $stmt = $pdo->prepare("
        UPDATE products 
        SET product_name = ?, price = ?, stock = ?, description = ?, category_id = ?
        WHERE id = ?
    ");
    $stmt->execute([
        $_POST['product_name'],
        $_POST['price'],
        $_POST['stock'],
        $_POST['description'],
        $_POST['category'],
        $_POST['product_id']
    ]);

    // Handle new images if any
    if (!empty($_FILES['new_images']['name'][0])) {
        $uploadDir = 'uploads/products/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['new_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['new_images']['error'][$key] === 0) {
                $fileName = uniqid() . '_' . $_FILES['new_images']['name'][$key];
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($tmp_name, $filePath)) {
                    $stmt = $pdo->prepare("
                        INSERT INTO product_images (product_id, image_path) 
                        VALUES (?, ?)
                    ");
                    $stmt->execute([$_POST['product_id'], $filePath]);
                }
            }
        }
    }

    $pdo->commit();
    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 