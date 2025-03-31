<?php
require_once 'mysqli_db.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "===== Checking Database Tables =====\n\n";

// Check escorts table
echo "Escorts Table:\n";
$result = $conn->query("SELECT escort_id, name, email, status FROM escorts");
if ($result) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: {$row['escort_id']}, Name: {$row['name']}, Email: {$row['email']}, Status: {$row['status']}\n";
        }
    } else {
        echo "No records found in escorts table\n";
    }
} else {
    echo "Error querying escorts table: {$conn->error}\n";
}

echo "\n";

// Check escorts_schedule table
echo "Escorts Schedule Table:\n";
$result = $conn->query("SELECT schedule_id, escort_id, day_of_week, start_time, end_time, status FROM escorts_schedule");
if ($result) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: {$row['schedule_id']}, Escort ID: {$row['escort_id']}, Day: {$row['day_of_week']}, Time: {$row['start_time']} - {$row['end_time']}, Status: {$row['status']}\n";
        }
    } else {
        echo "No records found in escorts_schedule table\n";
    }
} else {
    echo "Error querying escorts_schedule table: {$conn->error}\n";
}

// Get current day and time for testing
$now = new DateTime();
$currentDay = strtolower($now->format('l')); // Current day of week
$currentTime = $now->format('H:i:s'); // Current time

echo "\nCurrent day: $currentDay, Current time: $currentTime\n";

// Test the query used in get_escort.php
echo "\nTesting get_escort.php query with current time:\n";
$query = "SELECT e.escort_id, e.name, es.day_of_week, es.start_time, es.end_time, es.status 
          FROM escorts e 
          INNER JOIN escorts_schedule es ON e.escort_id = es.escort_id 
          WHERE e.status = 'active' 
          AND es.day_of_week = ? 
          AND es.start_time <= ? 
          AND es.end_time >= ? 
          AND (es.status = 'active' OR es.status = 'available')";

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $currentDay, $currentTime, $currentTime);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    if ($result->num_rows > 0) {
        echo "Found {$result->num_rows} available escorts:\n";
        while($row = $result->fetch_assoc()) {
            echo "ID: {$row['escort_id']}, Name: {$row['name']}, Day: {$row['day_of_week']}, Time: {$row['start_time']} - {$row['end_time']}, Status: {$row['status']}\n";
        }
    } else {
        echo "No escorts found with the current query\n";
    }
} else {
    echo "Error executing query: {$conn->error}\n";
}

$conn->close();