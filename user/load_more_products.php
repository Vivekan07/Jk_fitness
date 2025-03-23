<?php
include '../include/db.php';

try {
    $offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;
    $limit = 6; // Load 6 products at a time

    // Get products
    $query = "SELECT p.*, c.category_name, 
             (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) as main_image 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             ORDER BY p.created_at DESC
             LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $products = [];
    while ($product = $stmt->fetch()) {
        $image = $product['main_image'] ? '../' . $product['main_image'] : 'assets/images/no-image.jpg';
        $products[] = [
            'id' => $product['id'],
            'name' => htmlspecialchars($product['product_name']),
            'category' => htmlspecialchars($product['category_name']),
            'price' => number_format($product['price'], 2),
            'image' => htmlspecialchars($image)
        ];
    }

    // Check if there are more products
    $countQuery = "SELECT COUNT(*) FROM products";
    $totalProducts = $pdo->query($countQuery)->fetchColumn();
    $hasMore = ($offset + $limit) < $totalProducts;

    echo json_encode([
        'products' => $products,
        'hasMore' => $hasMore
    ]);

} catch(PDOException $e) {
    echo json_encode([
        'error' => 'Failed to load products',
        'products' => [],
        'hasMore' => false
    ]);
} 