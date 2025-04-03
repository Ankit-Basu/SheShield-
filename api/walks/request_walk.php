<?php
require_once '../../mysqli_db.php';
require_once '../../PHPMailer/Exception.php';
require_once '../../PHPMailer/PHPMailer.php';
require_once '../../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

header('Content-Type: application/json');

// Function to generate a unique walk ID
function generateWalkId() {
    return 'WALK-' . date('Ymd') . '-' . substr(uniqid(), -6);
}

try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        throw new Exception('Invalid request data');
    }

    $escortId = $data['escortId'] ?? '';
    $userId = $data['userId'] ?? '';
    $pickupLocation = $data['pickupLocation'] ?? '';
    $destination = $data['destination'] ?? '';
    $requestTime = $data['requestTime'] ?? date('Y-m-d H:i:s');

    if (!$escortId || !$pickupLocation || !$destination) {
        throw new Exception('Missing required fields');
    }

    // Get escort's details
    $stmt = $conn->prepare("SELECT email, name FROM escorts WHERE escort_id = ?");
    $stmt->bind_param("s", $escortId);
    $stmt->execute();
    $result = $stmt->get_result();
    $escort = $result->fetch_assoc();

    if (!$escort) {
        throw new Exception('Escort not found');
    }

    // Generate walk ID
    $walkId = generateWalkId();

    // Insert walk request into database
    $stmt = $conn->prepare("
        INSERT INTO walk_requests (
            walk_id, escort_id, user_id, pickup_location, destination, 
            request_time, status, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())
    ");

    $stmt->bind_param(
        "ssssss",
        $walkId,
        $escortId,
        $userId,
        $pickupLocation,
        $destination,
        $requestTime
    );

    if (!$stmt->execute()) {
        throw new Exception('Failed to save walk request');
    }

    // Send email - using the same simple approach as in test_email_simple.php
    $mail = new PHPMailer(true);
    try {
        // Disable debug output for API
        $mail->SMTPDebug = 0;
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'arshchouhan004@gmail.com';
        $mail->Password = 'qvgs zzeh aiiy iplc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use class constant instead of string
        $mail->Port = 465;
        
        // Recipients
        $mail->setFrom('arshchouhan004@gmail.com', 'SheShield');
        $mail->addAddress($escort['email'], $escort['name']);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Walk Request - SheShield';
        
        // Simple email body
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
        
        $mail->send();
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Walk request submitted successfully and notification sent to escort',
            'walkId' => $walkId,
            'emailSent' => true
        ]);
    } catch (Exception $e) {
        // Email failed but walk request was saved
        echo json_encode([
            'success' => true,
            'message' => 'Walk request submitted successfully but notification email failed',
            'walkId' => $walkId,
            'emailSent' => false,
            'emailError' => $mail->ErrorInfo
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
