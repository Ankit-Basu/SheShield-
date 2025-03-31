<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sheshield');

// Create database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SMS API configuration
define('FAST2SMS_API_KEY', 'IMuQxusTw23ftwIZ4vaxuGguVKSpuA759aOBu3N8PewuouQjraT8ilQrCriT');
?>