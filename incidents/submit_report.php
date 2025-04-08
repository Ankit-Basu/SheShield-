<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/php_error.log');

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../config/database.php';

$response = array();

try {
    // Get posted data
    $rawData = file_get_contents("php://input");
    error_log("Raw data received: " . $rawData);
    
    $data = json_decode($rawData);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON data: " . json_last_error_msg());
    }
    
    error_log("Processed data: " . print_r($data, true));
    
    // Validate required fields
    if (empty($data->incident_type) || empty($data->description) || empty($data->location)) {
        throw new Exception("Missing required fields: type, description, and location are required");
    }

    // Initialize database connection
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception("Database connection failed");
    }
    
    // Get user_id from session if logged in
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // Prepare SQL statement with optional personal information fields
    $query = "INSERT INTO incidents 
            (type, description, location, incident_date, user_id, status";
    
    // Add personal info fields if provided
    if (!empty($data->first_name)) {
        $query .= ", first_name, last_name, phone, email";
    }
    
    $query .= ") VALUES 
            (:type, :description, :location, :incident_date, :user_id, 'pending'";
    
    // Add personal info placeholders if provided
    if (!empty($data->first_name)) {
        $query .= ", :first_name, :last_name, :phone, :email";
    }
    
    $query .= ")";
    
    $stmt = $db->prepare($query);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . implode(", ", $db->errorInfo()));
    }
    
    // Format incident_date
    $incident_date = !empty($data->date_time) ? date('Y-m-d H:i:s', strtotime($data->date_time)) : date('Y-m-d H:i:s');
    
    // Bind required values
    $params = array(
        ":type" => htmlspecialchars(strip_tags($data->incident_type)),
        ":description" => htmlspecialchars(strip_tags($data->description)),
        ":location" => htmlspecialchars(strip_tags($data->location)),
        ":incident_date" => $incident_date,
        ":user_id" => $user_id
    );
    
    // Bind optional personal info if provided
    if (!empty($data->first_name)) {
        $params[":first_name"] = htmlspecialchars(strip_tags($data->first_name));
        $params[":last_name"] = htmlspecialchars(strip_tags($data->last_name));
        $params[":phone"] = htmlspecialchars(strip_tags($data->phone));
        $params[":email"] = htmlspecialchars(strip_tags($data->email));
    }
    
    // Bind all parameters
    foreach ($params as $param => $value) {
        if (!$stmt->bindValue($param, $value)) {
            throw new Exception("Failed to bind parameter: " . $param);
        }
    }
    
    // Execute statement
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute statement: " . implode(", ", $stmt->errorInfo()));
    }
    
    $response["status"] = "success";
    $response["message"] = "Report submitted successfully";
    $response["id"] = $db->lastInsertId();
    error_log("Report submitted successfully. ID: " . $db->lastInsertId());
    http_response_code(201);
    
} catch(Exception $e) {
    error_log("Report submission error: " . $e->getMessage());
    $response["status"] = "error";
    $response["message"] = $e->getMessage();
    http_response_code(400);
} catch(PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $response["status"] = "error";
    $response["message"] = "Database error occurred";
    http_response_code(500);
}

echo json_encode($response);
exit();
