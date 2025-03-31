<?php
require_once 'mysqli_db.php';

header('Content-Type: application/json');

// Get JSON data
$jsonData = json_decode(file_get_contents('php://input'), true);
$location = $jsonData['location'] ?? 'Not specified';
$destination = $jsonData['destination'] ?? 'Not specified';
$preferredTime = $jsonData['preferredTime'] ?? null;

try {
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // If preferred time is provided, use it; otherwise use current time
    if ($preferredTime) {
        $requestDateTime = new DateTime($preferredTime);
    } else {
        $requestDateTime = new DateTime();
    }
    
    // Get day of week in lowercase to match ENUM values in database
    $dayOfWeek = strtolower($requestDateTime->format('l')); // 'l' returns full day name
    
    // Get time in 24-hour format for comparison
    $requestTime = $requestDateTime->format('H:i:s');
    
    // Log the request details for debugging
    error_log("Escort request - Day: $dayOfWeek, Time: $requestTime");
    
    // First try to find escorts with exact day and time match
    $query = "SELECT e.* FROM escorts e 
              INNER JOIN escorts_schedule es ON e.escort_id = es.escort_id 
               WHERE e.status = 'active' 
              AND es.day_of_week = ? 
              AND es.start_time <= ? 
d              AND es.end_time >= ? 
              AND (es.status = 'active' OR es.status = 'available' OR es.status = '' OR es.status IS NULL) 
              ORDER BY e.rating DESC, e.completed_walks DESC LIMIT 1";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $dayOfWeek, $requestTime, $requestTime);
    
    error_log("Query parameters - Day: $dayOfWeek, Time: $requestTime");
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $escort = $result->fetch_assoc();

    if ($escort) {
        // Format response
        $response = [
            'success' => true,
            'escort' => [
                'id' => $escort['escort_id'],
                'name' => $escort['name'],
                'type' => $escort['type'],
                'rating' => floatval($escort['rating']),
                'completedWalks' => intval($escort['completed_walks']),
                'profilePic' => "https://ui-avatars.com/api/?name=" . urlencode($escort['name']) . "&background=random"
            ]
        ];
        
        error_log("Found escort: " . json_encode($response));
    } else {
        // Debug query
        error_log("No escorts found. Checking total escorts in system...");
        $debug_query = "SELECT COUNT(*) as total FROM escorts";
        $debug_result = $conn->query($debug_query);
        $total_escorts = $debug_result->fetch_assoc()['total'];
        
        error_log("Total escorts in system: " . $total_escorts);
        
        // Check schedules
        $debug_query = "SELECT COUNT(*) as total FROM escorts_schedule WHERE day_of_week = ? AND status = 'active'";
        $debug_stmt = $conn->prepare($debug_query);
        $debug_stmt->bind_param("s", $dayOfWeek);
        $debug_stmt->execute();
        $debug_result = $debug_stmt->get_result();
        $total_schedules = $debug_result->fetch_assoc()['total'];
        
        error_log("Total active schedules for $dayOfWeek: " . $total_schedules);
        
        $response = [
            'success' => false,
            'message' => 'No escorts are available at the moment. Please try again later.'
        ];
    }
} catch (Exception $e) {
    error_log("Error in get_escort.php: " . $e->getMessage());
    $response = [
        'success' => false,
        'message' => 'An error occurred while finding an escort. Please try again.'
    ];
}

echo json_encode($response);
