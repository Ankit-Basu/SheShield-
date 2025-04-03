<?php
require_once '../utils/session.php';

// Check if user is already logged in
if (Session::isLoggedIn()) {
    // Set session storage values to ensure client-side persistence
    $userId = Session::getUserId();
    $email = Session::get('email');
    
    // Return JSON response with session data and redirect URL
    header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json');
    echo json_encode([
        'status' => 'redirect',
        'url' => '../dashboard.php',
        'session_data' => [
            'user_id' => $userId,
            'email' => $email
        ]
    ]);
    exit();
}

// If not logged in, return normal response
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json');
echo json_encode(['status' => 'ok']);
?>