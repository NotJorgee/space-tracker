<?php
require 'config/db.php';

// Fetch categories for the dropdown menu
$categories = $pdo->query("SELECT * FROM object_categories")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Add Object | Universal Tracker</title>
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
            <a href="add.php" class="text-decoration-none text-light border-bottom border-primary pb-1">Add Object</a>
            <a href="manage.php" class="text-decoration-none text-muted-custom">Manage Fleet</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success bg-success bg-opacity-25 text-success border border-success mb-4 rounded-4">Target successfully added to fleet tracking!</div>
            <?php endif; ?>

            <div class="card custom-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-light"><i class="bi bi-plus-circle text-primary me-2"></i>Register New Target</h2>
                    <p class="text-faint-custom">Add a new station or celestial body to your active radar.</p>
                </div>

                <form method="POST" action="backend/process_add.php">
                    <div class="mb-3">
                        <label class="form-label text-muted-custom">Designation (Custom Name)</label>
                        <input type="text" name="custom_name" class="form-control custom-input" placeholder="e.g., Alpha Station, Jupiter" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted-custom">Object Class</label>
                        <select name="category_id" class="form-select custom-input" required>
                            <option value="" disabled selected>Select Classification...</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted-custom">API Reference ID</label>
                        <input type="text" name="api_reference_id" class="form-control custom-input" placeholder="e.g., 25544 for ISS, jupiter for Jupiter" required>
                        <small class="text-faint-custom mt-1 d-block">Use NORAD IDs for stations, and lowercase English names for planets.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted-custom">Tracking Priority</label>
                        <select name="tracking_priority" class="form-select custom-input" required>
                            <option value="High">High (Immediate Scan)</option>
                            <option value="Medium" selected>Medium (Standard Log)</option>
                            <option value="Low">Low (Background Track)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn custom-btn-primary w-100 py-3 fw-bold fs-5 mt-2">Initialize Tracking</button>
                </form>
            </div>
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