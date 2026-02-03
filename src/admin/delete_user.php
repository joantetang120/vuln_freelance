<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) ) {
    $userId = intval($_POST['user_id']);

    // Optional: Prevent deleting yourself
    if ($userId == $_SESSION['user_id']) {
        die("You cannot delete your own account.");
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");

    try {
        $stmt->execute(['id' => $userId]);
        header("Location: index.php?page=admin&message=User+deleted");
    } catch (PDOException $e) {
        die("Failed to delete user: " . $e->getMessage());
    }
}
