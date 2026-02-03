<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["message" => "Invalid request method"]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

$userId = $_SESSION['user_id'];
$user   = $conn->query("SELECT * FROM users WHERE id='$userId'")->fetch();

$username = $_POST['username'] ?? $user['username'];
$password = !empty($_POST['password']) ? md5($_POST['password']) : $user['password'];

// Handle file upload securely
$profile_pic_path = $user['profile_pic'];
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext     = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        $newName = uniqid('profile_', true) . "." . $ext;
        $uploadDir = '/var/www/html/public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadDir . $newName);
        $profile_pic_path = 'uploads/   ' . $newName;
    }
}

// Role protection (still fake for CTF)
if (isset($_POST['role'])) {
    $expected = md5($_SESSION['user_id'] . "admin");
    if (isset($_POST['allowedRole']) && $_POST['allowedRole'] === $expected) {
        $role = $_POST['role'];
    } else {
        $role = $user['role'];
    }
} else {
    $role = $user['role'];
}

// Update user
$sql = "UPDATE users SET username='$username', password='$password', profile_pic='$profile_pic_path', role='$role' WHERE id='$userId'";

try {
    $conn->exec($sql);
    $_SESSION['role'] = $role;
    echo json_encode([
        "message" => "Profile updated",
        "file"    => basename($profile_pic_path) // <-- just the file name
    ]);
} catch (PDOException $e) {
    echo json_encode(["message" => "Error: " . $e->getMessage()]);
}

