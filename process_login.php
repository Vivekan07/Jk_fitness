<?php
session_start();
include 'include/db.php';

try {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        throw new Exception('Username and password are required');
    }

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($_POST['password'], $admin['password'])) {
        throw new Exception('Invalid username or password');
    }

    // Set session variables
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];
    $_SESSION['admin_profile'] = $admin['profile_image'] ?? 'assets/images/default-profile.jpg';

    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 