<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$users = $conn->query("SELECT id, username,confirmed, role FROM users")->fetchAll();
include __DIR__ . '/../../templates/admin/dashboard.php';
