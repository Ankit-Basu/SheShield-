<?php
require_once 'mysqli_db.php';
require_once 'send_escort_email.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test data
$escortId = 'ESC-2025-001'; // Example escort ID
$requestDetails = array(
    'location' => 'Main Campus Gate',
    'destination' => 'University Library'
);

// Test email sending
$result = sendEscortEmail($escortId, $requestDetails);

// Display result
echo '<pre>';
print_r($result);
echo '</pre>';
?>
