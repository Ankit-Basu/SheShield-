<?php
// Simple test script to check email sending
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PHPMailer
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'mysqli_db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<h1>Email Test</h1>";

// Get escort email from database
$escortId = isset($_GET['escort_id']) ? $_GET['escort_id'] : 'ESC-2024-001';
$escortEmail = isset($_GET['email']) ? $_GET['email'] : 'ankitbasu960@gmail.com';
$escortName = 'Test Escort';

// Try to get escort from database if ID is provided
if ($escortId) {
    $stmt = $conn->prepare("SELECT email, name FROM escorts WHERE escort_id = ?");
    $stmt->bind_param("s", $escortId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $escortEmail = $row['email'];
        $escortName = $row['name'];
        echo "<p>Found escort in database: {$escortName} ({$escortEmail})</p>";
    } else {
        echo "<p>Escort with ID {$escortId} not found in database. Using default email.</p>";
    }
}

// Show all escorts in database
echo "<h2>All Escorts in Database:</h2>";
$result = $conn->query("SELECT escort_id, name, email FROM escorts");
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Escort ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['escort_id']}</td>";
    echo "<td>{$row['name']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td><a href='?escort_id={$row['escort_id']}'>Test with this escort</a></td>";
    echo "</tr>";
}
echo "</table>";

// Form to test with custom email
echo "<h2>Test with Custom Email:</h2>";
echo "<form method='get'>";
echo "Email: <input type='email' name='email' value='{$escortEmail}'>";
echo "<input type='submit' value='Test'>";
echo "</form>";

// Only send email if form was submitted
if (isset($_GET['escort_id']) || isset($_GET['email'])) {
    echo "<h2>Sending Test Email to: {$escortEmail}</h2>";
    
    try {
        $mail = new PHPMailer(true);
        
        // Include email configuration
        require_once 'config/email_config.php';
        
        // Server settings
        $mail->SMTPDebug = 3; // Enable more verbose debug output
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME; // Your Gmail address
        $mail->Password = SMTP_PASSWORD; // Your Gmail password or App Password
        $mail->SMTPSecure = SMTP_ENCRYPTION === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = SMTP_PORT;
        
        // Additional settings to help with connection issues
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Timeout = 60; // Set timeout to 60 seconds
        
        // Recipients
        $mail->setFrom(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
        $mail->addAddress($escortEmail, $escortName);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Test Email from SheShield';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #d946ef;'>Test Email</h2>
                <p>Hello {$escortName},</p>
                <p>This is a test email from SheShield to verify that our email system is working correctly.</p>
                <p>If you received this email, it means our email system is working!</p>
                <p>Time sent: " . date('Y-m-d H:i:s') . "</p>
                <div style='margin-top: 30px;'>
                    <p>Best regards,<br>SheShield Team</p>
                </div>
            </div>
        ";
        
        // Plain text version
        $mail->AltBody = "Hello {$escortName}, This is a test email from SheShield. Time: " . date('Y-m-d H:i:s');
        
        // Send email
        $mail->send();
        echo "<div style='color: green; padding: 10px; border: 1px solid green; margin-top: 20px;'>";
        echo "<strong>Success!</strong> Email was sent successfully to {$escortEmail}.";
        echo "</div>";
    } catch (Exception $e) {
        echo "<div style='color: red; padding: 10px; border: 1px solid red; margin-top: 20px;'>";
        echo "<strong>Error!</strong> Email could not be sent.<br>";
        echo "Mailer Error: " . $mail->ErrorInfo;
        echo "</div>";
        
        // Troubleshooting information
        echo "<h2>Troubleshooting Information:</h2>";
        echo "<pre>";
        echo "SMTP Host: " . SMTP_HOST . "\n";
        echo "SMTP Port: " . SMTP_PORT . "\n";
        echo "SMTP Security: " . SMTP_ENCRYPTION . "\n";
        echo "SMTP Username: " . SMTP_USERNAME . "\n";
        echo "Recipient: {$escortEmail}\n";
        echo "</pre>";
        
        // Common issues
        echo "<h2>Common Issues:</h2>";
        echo "<ul>";
        echo "<li>Gmail requires an App Password if 2-factor authentication is enabled</li>";
        echo "<li>Make sure 'Less secure app access' is enabled in your Google account if not using an App Password</li>";
        echo "<li>Check if your email provider blocks outgoing SMTP connections</li>";
        echo "<li>Verify that the recipient email address is valid</li>";
        echo "</ul>";
    }
}
?>
