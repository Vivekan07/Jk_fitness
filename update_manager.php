<?php
include 'include/db.php';

try {
    if (!isset($_POST['manager_id']) || empty($_POST['manager_id'])) {
        throw new Exception('Manager ID is required');
    }

    $updateFields = [
        'username' => $_POST['username'],
        'phone' => $_POST['phone'],
        'nic' => $_POST['nic'],
        'address' => $_POST['address']
    ];

    // Handle image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $uploadDir = 'uploads/profiles/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . $_FILES['profile_image']['name'];
        $uploadFile = $uploadDir . $fileName;

        if (!getimagesize($_FILES['profile_image']['tmp_name'])) {
            throw new Exception('Invalid image file');
        }

        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
            throw new Exception('Failed to upload image');
        }

        // Delete old profile image
        $stmt = $pdo->prepare("SELECT profile_image FROM branch_managers WHERE id = ?");
        $stmt->execute([$_POST['manager_id']]);
        $oldImage = $stmt->fetchColumn();
        if ($oldImage && file_exists($oldImage)) {
            unlink($oldImage);
        }

        $updateFields['profile_image'] = $uploadFile;
    }

    // Only update password if provided
    if (!empty($_POST['password'])) {
        $updateFields['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    // Build the SQL query dynamically
    $sql = "UPDATE branch_managers SET ";
    $params = [];
    foreach ($updateFields as $field => $value) {
        $sql .= "$field = ?, ";
        $params[] = $value;
    }
    $sql = rtrim($sql, ", ") . " WHERE id = ?";
    $params[] = $_POST['manager_id'];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(['status' => 'success']);

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo json_encode(['status' => 'error', 'message' => 'Username, Phone or NIC already exists']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 