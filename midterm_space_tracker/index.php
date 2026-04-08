<?php
require 'config/db.php';
// Fetch objects with their category names using a JOIN
$stmt = $pdo->query("SELECT o.*, c.category_name FROM tracked_objects o JOIN object_categories c ON o.category_id = c.category_id ORDER BY o.tracking_priority ASC");
$objects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Universal Object Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="fade-in">

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar pt-3 pb-3 sticky-top mb-5">
    <div class="container d-flex flex-column text-center">
        <h5 class="text-light mb-3 fw-bold">MIDTERM PRACTICAL: Web-Based Application Development with API Integration and CRUD Operations.</h5>
        <div class="d-flex gap-4">
            <a href="index.php" class="text-decoration-none text-light border-bottom border-primary pb-1">View Radar</a>
            <a href="add.php" class="text-decoration-none text-muted-custom">Add Object</a>
            <a href="manage.php" class="text-decoration-none text-muted-custom">Manage Fleet</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-12 mb-4">
            <div class="card custom-card p-4">
                <h3 class="fw-bold mb-3 border-bottom border-secondary pb-2 text-primary">Live Telemetry</h3>
                <div id="telemetry-display" class="text-light">
                    <p class="text-faint-custom">Select an object from your fleet to initialize telemetry...</p>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card custom-card p-4">
                <h3 class="fw-bold mb-4 border-bottom border-secondary pb-2">Active Tracking Fleet</h3>
                <div class="table-responsive">
                    <table class="table custom-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Class</th>
                                <th>Priority</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($objects as $obj): ?>
                            <tr>
                                <td class="fw-bold fs-5"><?= htmlspecialchars($obj['custom_name']) ?></td>
                                <td><span class="badge bg-secondary bg-opacity-25 text-light border border-secondary"><?= htmlspecialchars($obj['category_name']) ?></span></td>
                                <td>
                                    <?php 
                                        $badgeColor = $obj['tracking_priority'] == 'High' ? 'danger' : ($obj['tracking_priority'] == 'Medium' ? 'primary' : 'success');
                                    ?>
                                    <span class="badge bg-<?= $badgeColor ?> bg-opacity-25 text-<?= $badgeColor ?> border border-<?= $badgeColor ?> rounded-pill px-3"><?= $obj['tracking_priority'] ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm custom-btn-primary fetch-data-btn" 
                                            data-id="<?= htmlspecialchars($obj['api_reference_id']) ?>" 
                                            data-type="<?= $obj['category_name'] == 'Planet' ? 'planet' : 'station' ?>">
                                        Scan Target
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>