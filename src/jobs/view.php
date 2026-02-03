<?php
require_once __DIR__ . '/../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id'])) {
    die("Job ID required");
}

$job_id = $_GET['id'];
$sql = "SELECT j.*, u.username FROM jobs j JOIN users u ON j.user_id = u.id WHERE j.id = $job_id";
$job = $conn->query($sql)->fetch();

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /index.php?page=login");
        exit;
    }
    $user_id = $_SESSION['user_id'];

    // BUSINESS LOGIC FLAW: Can apply to own job
    $uploadDir =  '/var/www/html/public/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $file = $_FILES['cv'];
    $allowedMime = ['application/pdf'];

    // Check MIME type
    if (!in_array(mime_content_type($file['tmp_name']), $allowedMime)) {
        $message = "Only PDF files allowed!";
    } else {
        // Generate unique server name (but keep user extension)
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = uniqid('cv_') . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
            $message = "Upload failed. Check folder permissions.";
        } else {
            $sql = "INSERT INTO applications (job_id, user_id, cv_path) 
                    VALUES ('$job_id', '$user_id', '$newName')";
            try {
                $conn->exec($sql);
                // Show success + uploaded file name
                $message = "Applied with CV successfully! Uploaded file: " . htmlspecialchars($newName);
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
            }
        }
    }
}

include __DIR__ . '/../../templates/jobs/view.php';
