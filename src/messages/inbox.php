<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php?page=login");
    exit;
}

$userId = $_SESSION['user_id'];
$sql = "SELECT m.id, m.subject, m.body, m.created_at, u.username AS sender 
        FROM messages m 
        JOIN users u ON m.sender_id = u.id 
        WHERE m.receiver_id = '$userId'
        ORDER BY m.created_at DESC";
$result = $conn->query($sql);

$messages = [];
while ($row = $result->fetch()) {
    $messages[] = $row;
}

include __DIR__ . '/../../templates/messages/inbox.php';
