<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO tracked_objects (category_id, custom_name, api_reference_id, tracking_priority) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['category_id'], 
        $_POST['custom_name'], 
        $_POST['api_reference_id'], 
        $_POST['tracking_priority']
    ]);
    header("Location: ../add.php?success=1");
    exit;
}
?>