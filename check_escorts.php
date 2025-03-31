<?php
require_once 'mysqli_db.php';

header('Content-Type: text/plain');

echo "Checking Escorts Tables\n";
echo "=====================\n\n";

// Check escorts table
echo "ESCORTS TABLE:\n";
echo "-------------\n";
$result = $conn->query("SELECT * FROM escorts");
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: {$row['escort_id']}, Name: {$row['name']}, Status: {$row['status']}, Verification: {$row['verification_status']}\n";
        }
        echo "\nTotal records: {$result->num_rows}\n\n";
    } else {
        echo "No records found in escorts table.\n\n";
    }
} else {
    echo "Error querying escorts table: {$conn->error}\n\n";
}

// Check escorts_schedule table
echo "ESCORTS_SCHEDULE TABLE:\n";
echo "----------------------\n";
$result = $conn->query("SELECT * FROM escorts_schedule");
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Schedule ID: {$row['schedule_id']}, Escort ID: {$row['escort_id']}, Day: {$row['day_of_week']}, Time: {$row['start_time']} - {$row['end_time']}\n";
        }
        echo "\nTotal records: {$result->num_rows}\n\n";
    } else {
        echo "No records found in escorts_schedule table.\n\n";
    }
} else {
    echo "Error querying escorts_schedule table: {$conn->error}\n\n";
}

// Insert sample data if tables are empty
echo "CHECKING IF SAMPLE DATA NEEDS TO BE INSERTED:\n";
echo "------------------------------------------\n";

$result = $conn->query("SELECT COUNT(*) as count FROM escorts");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
    echo "No escorts found. Inserting sample data...\n";
    
    // Insert sample escort
    $escortId = 'ESC-2023-001';
    $stmt = $conn->prepare("INSERT INTO escorts (
        escort_id, name, email, phone, type, gender, status, 
        rating, total_ratings, total_walks, completed_walks, 
        id_proof_type, id_proof_number, verification_status, description
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $name = 'Sarah Johnson';
    $email = 'sarah.j@example.com';
    $phone = '+1234567890';
    $type = 'student';
    $gender = 'female';
    $status = 'active';
    $rating = 4.9;
    $totalRatings = 245;
    $totalWalks = 156;
    $completedWalks = 156;
    $idProofType = 'student_id';
    $idProofNumber = 'STU2023001';
    $verificationStatus = 'verified';
    $description = 'Dedicated student volunteer committed to ensuring campus safety.';
    
    $stmt->bind_param("ssssssdiiissss", 
        $escortId, $name, $email, $phone, $type, $gender, $status,
        $rating, $totalRatings, $totalWalks, $completedWalks,
        $idProofType, $idProofNumber, $verificationStatus, $description
    );
    
    if ($stmt->execute()) {
        echo "Sample escort inserted successfully.\n";
    } else {
        echo "Error inserting sample escort: {$stmt->error}\n";
    }
    
    // Insert schedule for the sample escort
    $result = $conn->query("SELECT COUNT(*) as count FROM escorts_schedule");
    $row = $result->fetch_assoc();
    if ($row['count'] == 0) {
        echo "No escort schedules found. Inserting sample schedule...\n";
        
        // Get current day of week
        $dayOfWeek = strtolower(date('l')); // 'l' returns full day name
        
        $stmt = $conn->prepare("INSERT INTO escorts_schedule (
            escort_id, day_of_week, start_time, end_time, status
        ) VALUES (?, ?, ?, ?, ?)");
        
        $startTime = '08:00:00';
        $endTime = '20:00:00';
        $scheduleStatus = 'available';
        
        $stmt->bind_param("sssss", 
            $escortId, $dayOfWeek, $startTime, $endTime, $scheduleStatus
        );
        
        if ($stmt->execute()) {
            echo "Sample schedule inserted successfully for day: {$dayOfWeek}.\n";
        } else {
            echo "Error inserting sample schedule: {$stmt->error}\n";
        }
    } else {
        echo "Escort schedules already exist.\n";
    }
} else {
    echo "Escorts already exist in the database.\n";
}

echo "\nDone!\n";