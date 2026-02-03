<?php
require_once __DIR__ . '/../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$jobs = [];

$search = $_GET['q'] ?? '';

// INTENTIONALLY VULNERABLE (SQL Injection)
$sql = "SELECT j.id, j.title, j.description, u.username 
        FROM jobs j JOIN users u ON j.user_id = u.id 
        WHERE j.title LIKE '%$search%' ORDER BY j.id DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

include __DIR__ . '/../../templates/jobs/list.php';
