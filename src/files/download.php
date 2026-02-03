<?php
$file = $_GET['file'] ?? '';
$path =  '/var/www/uploads/' . $file;

// No canonical path check → traversal possible
if (file_exists($path)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    readfile($path);
} else {
    echo "File not found";
}
