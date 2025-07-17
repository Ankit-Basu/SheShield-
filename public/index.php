<?php
// This is a simple router for the built-in PHP web server
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route to the appropriate file
if ($path === '/' || $path === '') {
    require __DIR__ . '/../index.php';
} else {
    $file = __DIR__ . '/..' . $path;
    if (file_exists($file)) {
        return false; // Serve the file directly
    } else {
        require __DIR__ . '/../index.php'; // Let the main app handle the routing
    }
}
