<?php
// Test script specifically for Request Walk email functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include required files
require_once 'mysqli_db.php';
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<h1>Request Walk Email Test</h1>";

// Get escort ID from query parameter or use default
$escortId = isset($_GET['escort_id']) ? $_GET['escort_id'] : '';

// Show all escorts in database
echo "<h2>Available Escorts:</h2>";
$result = $conn->query("SELECT escort_id, name, email FROM escorts");
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Escort ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['escort_id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td><a href='?escort_id={$row['escort_id']}'>Test with this escort</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No escorts found in database</td></tr>";
}
echo "</table>";

// If no escort ID is provided, show form to select one
if (empty($escortId)) {
    echo "<p>Please select an escort from the table above to test the email functionality.</p>";
    exit;
}

// Get escort details
$stmt = $conn->prepare("SELECT email, name FROM escorts WHERE escort_id = ?");
$stmt->bind_param("s", $escortId);
$stmt->execute();
$result = $stmt->get_result();
$escort = $result->fetch_assoc();

if (!$escort) {
    echo "<div style='color: red; padding: 10px; border: 1px solid red; margin-top: 20px;'>";
    echo "<strong>Error!</strong> Escort with ID {$escortId} not found.";
    echo "</div>";
    exit;
}

echo "<h2>Testing Request Walk Email for: {$escort['name']} ({$escort['email']})</h2>";

// Generate a test walk ID
$walkId = 'WALK-' . date('Ymd') . '-TEST';

// Sample request data
$pickupLocation = 'Main Campus Gate';
$destination = 'University Library';
$requestTime = date('Y-m-d H:i:s');

// Display test data
echo "<h3>Test Data:</h3>";
echo "<ul>";
echo "<li><strong>Walk ID:</strong> {$walkId}</li>";
echo "<li><strong>Pickup Location:</strong> {$pickupLocation}</li>";
echo "<li><strong>Destination:</strong> {$destination}</li>";
echo "<li><strong>Request Time:</strong> {$requestTime}</li>";
echo "</ul>";

// Send test email
try {
    // Include email configuration
    require_once 'config/email_config.php';
    
    $mail = new PHPMailer(true);
    
    // Server settings with debug output
    $mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_ENCRYPTION === 'tls' ? 'tls' : 'ssl';
    $mail->Port = SMTP_PORT;
    
    // Recipients
    $mail->setFrom(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
    $mail->addAddress($escort['email'], $escort['name']);
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Walk Request - SheShield';
    
    // Email body - exactly the same as in request_walk.php
    $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h2 style='color: #d946ef;'>New Walk Request</h2>
            <p>Hello {$escort['name']},</p>
            <p>You have received a new walk request with the following details:</p>
            
            <div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                <p><strong>Walk ID:</strong> {$walkId}</p>
                <p><strong>Pickup Location:</strong> {$pickupLocation}</p>
                <p><strong>Destination:</strong> {$destination}</p>
                <p><strong>Request Time:</strong> {$requestTime}</p>
            </div>
            
            <p>Please respond to this request as soon as possible through your SheShield dashboard.</p>
            
            <div style='margin-top: 30px;'>
                <p>Best regards,<br>SheShield Team</p>
            </div>
        </div>
    ";
    
    // Send the email
    $mail->send();
    
    // Show success message
    echo "<div style='color: green; padding: 10px; border: 1px solid green; margin-top: 20px;'>";
    echo "<strong>Success!</strong> Email was sent successfully to {$escort['email']}.";
    echo "</div>";
    
} catch (Exception $e) {
    // Show error message
    echo "<div style='color: red; padding: 10px; border: 1px solid red; margin-top: 20px;'>";
    echo "<strong>Error!</strong> Email could not be sent.<br>";
    echo "Mailer Error: " . $mail->ErrorInfo;
    echo "</div>";
    
    // Troubleshooting information
    echo "<h3>Troubleshooting Information:</h3>";
    echo "<pre>";
    echo "SMTP Host: " . SMTP_HOST . "\n";
    echo "SMTP Port: " . SMTP_PORT . "\n";
    echo "SMTP Security: " . SMTP_ENCRYPTION . "\n";
    echo "SMTP Username: " . SMTP_USERNAME . "\n";
    echo "Recipient: {$escort['email']}\n";
    echo "</pre>";
    
    // Common issues
    echo "<h3>Common Issues:</h3>";
    echo "<ul>";
    echo "<li>Gmail requires an App Password if 2-factor authentication is enabled</li>";
    echo "<li>Make sure 'Less secure app access' is enabled in your Google account if not using an App Password</li>";
    echo "<li>Check if your email provider blocks outgoing SMTP connections</li>";
    echo "<li>Verify that the recipient email address is valid</li>";
    echo "</ul>";
}

// Show link to actual Request Walk page
echo "<p><a href='walkwithus.php'>Go to Walk With Us page</a></p>";
?>
