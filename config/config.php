<?php
$host = getenv('DB_HOST') ?: "db";
$db   = getenv('DB_NAME') ?: "vulnmarket";
$user = getenv('DB_USER') ?: "vulnuser";
$pass = getenv('DB_PASSWORD') ?: "vulnpassword";
$port = getenv('DB_PORT') ?: "5432";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $conn = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
