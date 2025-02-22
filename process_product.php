<?php
include 'include/db.php';

try {
    // Start transaction
    $pdo->beginTransaction();

    // Basic validation
    if (empty($_POST['product_name']) || empty($_POST['price']) || empty($_POST['stock']) || 
        empty($_POST['description']) || empty($_POST['category']) || empty($_FILES['product_images'])) {
        throw new Exception('All fields are required');
    }

    // Insert product
    $stmt = $pdo->prepare("INSERT INTO products (product_name, price, stock, description, category_id) 
                          VALUES (:name, :price, :stock, :description, :category)");
    
    $stmt->execute([
        ':name' => $_POST['product_name'],
        ':price' => $_POST['price'],
        ':stock' => $_POST['stock'],
        ':description' => $_POST['description'],
        ':category' => $_POST['category']
    ]);

    $product_id = $pdo->lastInsertId();

    // Handle image uploads
    $uploadDir = 'uploads/products/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadedFiles = [];
    foreach ($_FILES['product_images']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['product_images']['error'][$key] === 0) {
            $fileName = uniqid() . '_' . $_FILES['product_images']['name'][$key];
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmp_name, $filePath)) {
                // Insert image record
                $stmt = $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :path)");
                $stmt->execute([
                    ':product_id' => $product_id,
                    ':path' => $filePath
                ]);
                $uploadedFiles[] = $filePath;
            }
        }
    }

    if (empty($uploadedFiles)) {
        throw new Exception('No images were uploaded successfully');
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode(['status' => 'success', 'message' => 'Product added successfully']);

} catch (Exception $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Delete any uploaded files if there was an error
    foreach ($uploadedFiles as $file) {
        if (file_exists($file)) {
            unlink($file);
        }
    }

    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 