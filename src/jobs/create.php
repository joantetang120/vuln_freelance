<?php
require_once __DIR__ . '/../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php?page=login");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    // Direct query, no prepared statement (safe from our perspective intentionally)
    $sql = "INSERT INTO jobs (title, description, user_id) VALUES ('$title', '$description', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        $message = "Job created successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

include __DIR__ . '/../../templates/jobs/create.php';
