<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php?page=login");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver = $_POST['receiver_id'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $sender = $_SESSION['user_id'];

    // VULNERABLE: no escaping or sanitization (Stored XSS possible)
    $sql = "INSERT INTO messages (sender_id, receiver_id, subject, body) 
            VALUES ('$sender', '$receiver', '$subject', '$body')";
    if ($conn->query($sql)) {
        $message = "Message sent!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$users = $conn->query("SELECT id, username, role FROM users")->fetch_all(MYSQLI_ASSOC);
include __DIR__ . '/../../templates/messages/send.php';
