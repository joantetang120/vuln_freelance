<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php?page=login");
    exit;
}

// Fetch current user data to populate the template
$userId = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id='$userId'")->fetch();
$message = ""; // left for compatibility (not used in fetch version)

include __DIR__ . '/../../templates/users/profile.php';
