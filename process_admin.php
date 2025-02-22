<?php
include 'include/db.php';

try {
    // Validate required fields
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['nic'])) {
        throw new Exception('All fields are required');
    }

    // Handle image upload
    $profileImage = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $uploadDir = 'uploads/admin_profiles/';
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

    // Insert admin
    $stmt = $pdo->prepare("INSERT INTO admins (username, password, nic, profile_image) 
                          VALUES (:username, :password, :nic, :profile_image)");
    
    $stmt->execute([
        ':username' => $_POST['username'],
        ':password' => $hashedPassword,
        ':nic' => $_POST['nic'],
        ':profile_image' => $profileImage
    ]);

    echo json_encode(['status' => 'success']);

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo json_encode(['status' => 'error', 'message' => 'Username or NIC already exists']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 