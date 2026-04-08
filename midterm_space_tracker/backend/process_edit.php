<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE tracked_objects SET custom_name = ?, tracking_priority = ? WHERE object_id = ?");
    $stmt->execute([
        $_POST['custom_name'], 
        $_POST['tracking_priority'], 
        $_POST['object_id']
    ]);
    header("Location: ../manage.php?updated=1");
    exit;
}
?>