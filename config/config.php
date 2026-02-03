<?php
$host = "db";
$db   = "vulnmarket";
$user = "vulnuser";
$pass = "vulnpassword";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
