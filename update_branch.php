<?php
include 'include/db.php';

try {
    if (!isset($_POST['branch_id']) || empty($_POST['branch_id'])) {
        throw new Exception('Branch ID is required');
    }

    // Check if manager is already assigned to another branch
    $stmt = $pdo->prepare("SELECT id FROM branches WHERE branch_manager_id = ? AND id != ?");
    $stmt->execute([$_POST['branch_manager_id'], $_POST['branch_id']]);
    if ($stmt->fetch()) {
        throw new Exception('Selected manager is already assigned to another branch');
    }

    // Update branch
    $stmt = $pdo->prepare("UPDATE branches SET 
                            branch_name = :branch_name,
                            location = :location,
                            phone = :phone,
                            branch_manager_id = :branch_manager_id
                          WHERE id = :branch_id");

    $stmt->execute([
        ':branch_name' => $_POST['branch_name'],
        ':location' => $_POST['location'],
        ':phone' => $_POST['phone'],
        ':branch_manager_id' => $_POST['branch_manager_id'],
        ':branch_id' => $_POST['branch_id']
    ]);

    echo json_encode(['status' => 'success']);

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo json_encode(['status' => 'error', 'message' => 'Branch name or phone number already exists']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 