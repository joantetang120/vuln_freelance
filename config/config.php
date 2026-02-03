<?php
$host = getenv('DB_HOST') ?: "db";
$db   = getenv('DB_NAME') ?: "vulnmarket";
$user = getenv('DB_USER') ?: "vulnuser";
$pass = getenv('DB_PASSWORD') ?: "vulnpassword";
$port = getenv('DB_PORT') ?: "3306";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
