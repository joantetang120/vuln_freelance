<?php
require_once __DIR__ . '/../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];

    // Mise à jour : confirmé + rôle = admin
    $stmt = $conn->prepare("UPDATE users SET confirmed = 1 WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Redirection vers la page admin
header('Location: index.php?page=admin');
exit;
