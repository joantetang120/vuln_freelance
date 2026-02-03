<?php
require_once __DIR__ . '/../../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// VULNERABILITY: no role check → anyone can access
$sql = "SELECT a.id, a.job_id, a.user_id, a.cv_path, u.username AS applicant, j.title AS job_title
        FROM applications a 
        JOIN users u ON a.user_id = u.id
        JOIN jobs j ON a.job_id = j.id
        ORDER BY a.id DESC";
$result = $conn->query($sql);

$applications = [];
while ($row = $result->fetch()) {
    $applications[] = $row;
}

include __DIR__ . '/../../templates/admin/applications.php';
