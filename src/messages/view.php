<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php?page=login");
    exit;
}

$id = $_GET['id'];

// VULNERABILITY: no check that this message belongs to the user (IDOR)
$sql = "SELECT m.id, m.subject, m.body, m.created_at, u.username AS sender 
        FROM messages m 
        JOIN users u ON m.sender_id = u.id 
        WHERE m.id = '$id'";
$message = $conn->query($sql)->fetch();

include __DIR__ . '/../../templates/messages/view.php';
