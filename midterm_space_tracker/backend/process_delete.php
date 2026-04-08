<?php
require '../config/db.php';

if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM tracked_objects WHERE object_id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header("Location: ../manage.php?deleted=1");
    exit;
}
?>