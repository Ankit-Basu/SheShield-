<?php
require_once '../../includes/EmailHelper.php';
require_once '../../mysqli_db.php';

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

    // Get escort's email
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

    // Send email notification to escort
    try {
        $emailHelper = new EmailHelper();
        $emailDetails = [
            'walkId' => $walkId,
            'pickupLocation' => $pickupLocation,
            'destination' => $destination,
            'requestTime' => $requestTime
        ];
        
        $emailHelper->sendWalkRequestEmail($escort['email'], $escort['name'], $emailDetails);
        
        echo json_encode([
            'success' => true,
            'message' => 'Walk request submitted successfully',
            'walkId' => $walkId
        ]);
    } catch (Exception $e) {
        // Log email error but don't fail the request
        error_log("Email notification failed: " . $e->getMessage());
        echo json_encode([
            'success' => true,
            'message' => 'Walk request submitted successfully but notification email failed',
            'walkId' => $walkId
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
