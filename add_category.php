<?php
include 'include/db.php';

try {
    if (!isset($_POST['category_name']) || empty($_POST['category_name'])) {
        throw new Exception('Category name is required');
    }

    $categoryName = trim($_POST['category_name']);

    // Check if category already exists
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE category_name = ?");
    $stmt->execute([$categoryName]);
    if ($stmt->fetch()) {
        throw new Exception('Category already exists');
    }

    // Insert new category
    $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->execute([$categoryName]);
    
    $categoryId = $pdo->lastInsertId();

    echo json_encode([
        'status' => 'success',
        'category_id' => $categoryId,
        'message' => 'Category added successfully'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?> 