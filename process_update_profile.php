<?php
session_start();
include 'include/db.php';

try {
    if (!isset($_SESSION['admin_id'])) {
        throw new Exception('Unauthorized access');
    }

    $adminId = $_SESSION['admin_id'];
    $username = $_POST['username'];
    $nic = $_POST['nic'];
    $profileImage = null;

    // Handle image upload
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

        // Delete old profile image
        $stmt = $pdo->prepare("SELECT profile_image FROM admins WHERE id = ?");
        $stmt->execute([$adminId]);
        $oldImage = $stmt->fetchColumn();
        if ($oldImage && file_exists($oldImage)) {
            unlink($oldImage);
        }

        $profileImage = $uploadFile;
    }

    // Update admin details
    $stmt = $pdo->prepare("UPDATE admins SET username = ?, nic = ?, profile_image = ? WHERE id = ?");
    $stmt->execute([$username, $nic, $profileImage, $adminId]);

    // Return the new image path
    echo json_encode(['status' => 'success', 'new_image' => $profileImage]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 