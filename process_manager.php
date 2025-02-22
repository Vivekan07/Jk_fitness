<?php
include 'include/db.php';

try {
    // Validate required fields
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['phone']) || 
        empty($_POST['nic']) || empty($_POST['address'])) {
        throw new Exception('All fields are required');
    }

    // Handle image upload
    $profileImage = null;
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

        $profileImage = $uploadFile;
    }

    // Hash password
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert manager
    $stmt = $pdo->prepare("INSERT INTO branch_managers (username, password, phone, nic, address, profile_image) 
                          VALUES (:username, :password, :phone, :nic, :address, :profile_image)");
    
    $stmt->execute([
        ':username' => $_POST['username'],
        ':password' => $hashedPassword,
        ':phone' => $_POST['phone'],
        ':nic' => $_POST['nic'],
        ':address' => $_POST['address'],
        ':profile_image' => $profileImage
    ]);

    echo json_encode(['status' => 'success']);

} catch (PDOException $e) {
    if ($e->getCode() == 23000) { // Duplicate entry
        echo json_encode(['status' => 'error', 'message' => 'Username, Phone or NIC already exists']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 