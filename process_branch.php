<?php
include 'include/db.php';

try {
    // Validate required fields
    if (empty($_POST['branch_name']) || empty($_POST['location']) || 
        empty($_POST['phone']) || empty($_POST['branch_manager_id'])) {
        throw new Exception('All fields are required');
    }

    // Check if manager is already assigned to another branch
    $stmt = $pdo->prepare("SELECT id FROM branches WHERE branch_manager_id = ?");
    $stmt->execute([$_POST['branch_manager_id']]);
    if ($stmt->fetch()) {
        throw new Exception('Selected manager is already assigned to another branch');
    }

    // Insert branch
    $stmt = $pdo->prepare("INSERT INTO branches (branch_name, location, phone, branch_manager_id) 
                          VALUES (:branch_name, :location, :phone, :branch_manager_id)");
    
    $stmt->execute([
        ':branch_name' => $_POST['branch_name'],
        ':location' => $_POST['location'],
        ':phone' => $_POST['phone'],
        ':branch_manager_id' => $_POST['branch_manager_id']
    ]);

    echo json_encode(['status' => 'success']);

} catch (PDOException $e) {
    if ($e->getCode() == 23000) { // Duplicate entry
        echo json_encode(['status' => 'error', 'message' => 'Branch name or phone number already exists']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 