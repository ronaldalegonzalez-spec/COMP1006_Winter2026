<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Tracker</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Time Tracker</h1>
<!-- Display welcome message and logout button if user is logged in -->
<div class="text-end mb-3">
    <?php if (isset($_SESSION['user_id'])): ?>
        <span>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></span>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    <?php else: ?>
        <a href="login.php" class="btn btn-primary btn-sm">Login</a>
        <a href="register.php" class="btn btn-secondary btn-sm">Register</a>
    <?php endif; ?>
</div>
