<?php
require_once __DIR__ . '/../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user';

    // INTENTIONALLY WEAK: MD5 for password hashing
    $hashed = md5($password);

    // Direct query, no prepared statements (SQLi risk later)
    $sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$hashed', '$email', '$role')";
    try {
        $conn->exec($sql);
        $message = "Account created successfully. <a href='index.php?page=login'>Login</a>";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

include __DIR__ . '/../../templates/auth/register_form.php';
