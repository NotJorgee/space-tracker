<?php
require 'config/db.php';

// Fetch objects to manage
$stmt = $pdo->query("SELECT o.*, c.category_name FROM tracked_objects o JOIN object_categories c ON o.category_id = c.category_id ORDER BY o.object_id DESC");
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Manage Fleet | Universal Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="fade-in">

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar pt-3 pb-3 sticky-top mb-5">
    <div class="container d-flex flex-column text-center">
        <h5 class="text-light mb-3 fw-bold">MIDTERM PRACTICAL: Web-Based Application Development with API Integration and CRUD Operations.</h5>
        <div class="d-flex gap-4">
            <a href="index.php" class="text-decoration-none text-muted-custom">View Radar</a>
            <a href="add.php" class="text-decoration-none text-muted-custom">Add Object</a>
            <a href="manage.php" class="text-decoration-none text-light border-bottom border-primary pb-1">Manage Fleet</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="card custom-card p-4">
        <h3 class="fw-bold mb-4 border-bottom border-secondary pb-2"><i class="bi bi-gear text-primary me-2"></i>Fleet Management Command</h3>
        
        <?php if(isset($_GET['deleted'])): ?>
            <div class="alert alert-danger bg-danger bg-opacity-25 text-danger border border-danger">Target removed from fleet.</div>
        <?php endif; ?>
        <?php if(isset($_GET['updated'])): ?>
            <div class="alert alert-info bg-info bg-opacity-25 text-info border border-info">Target parameters updated successfully.</div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Designation (Edit)</th>
                        <th>Priority (Edit)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($objects as $obj): ?>
                    <tr>
                        <td><span class="badge bg-secondary bg-opacity-25 text-light border border-secondary"><?= htmlspecialchars($obj['category_name']) ?></span></td>
                        
                        <form method="POST" action="backend/process_edit.php">
                            <input type="hidden" name="object_id" value="<?= $obj['object_id'] ?>">
                            
                            <td>
                                <input type="text" name="custom_name" class="form-control custom-input form-control-sm" value="<?= htmlspecialchars($obj['custom_name']) ?>" required>
                            </td>
                            <td>
                                <select name="tracking_priority" class="form-select custom-input form-select-sm">
                                    <option value="High" <?= $obj['tracking_priority'] == 'High' ? 'selected' : '' ?>>High</option>
                                    <option value="Medium" <?= $obj['tracking_priority'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
                                    <option value="Low" <?= $obj['tracking_priority'] == 'Low' ? 'selected' : '' ?>>Low</option>
                                </select>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-sm custom-btn-outline px-3">Update</button>
                                    <a href="backend/process_delete.php?delete_id=<?= $obj['object_id'] ?>" class="btn btn-sm custom-btn-danger px-3" onclick="return confirm('Confirm deletion of target from radar?')">Drop</a>
                                </div>
                            </td>
                        </form>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($objects)) echo "<tr><td colspan='4' class='text-center text-muted-custom py-4'>Radar is empty. Please add objects.</td></tr>"; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="mt-5 pb-4 text-center text-muted-custom border-top border-secondary pt-4">
    <div class="container">
        <p class="mb-1 fw-bold text-light">Name: [Insert Name] | Year & Section: [Insert Year/Sec]</p>
        <p class="mb-0">Subject: [Insert Subject] | Date of Midterm: [Insert Date]</p>
    </div>
</footer>
</body>
</html>