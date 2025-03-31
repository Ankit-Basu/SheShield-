<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/User.php';

$response = array();

try {
    // Get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    if (!empty($data->user_id) && !empty($data->email)) {
        // Verify against session data
        if (isset($_SESSION['user_id']) && 
            $_SESSION['user_id'] == $data->user_id && 
            $_SESSION['email'] == $data->email) {
            
            $response["status"] = "success";
            $response["message"] = "Session valid";
            $response["user"] = array(
                "id" => $_SESSION['user_id'],
                "email" => $_SESSION['email'],
                "first_name" => $_SESSION['first_name']
            );
            http_response_code(200);
        } else {
            // Try to verify against database
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);
            
            if ($user->getById($data->user_id) && $user->email === $data->email) {
                // User exists and matches, create new session
                $_SESSION['user_id'] = $user->id;
                $_SESSION['email'] = $user->email;
                $_SESSION['first_name'] = $user->first_name;
                
                $response["status"] = "success";
                $response["message"] = "Session renewed";
                $response["user"] = array(
                    "id" => $user->id,
                    "email" => $user->email,
                    "first_name" => $user->first_name
                );
                http_response_code(200);
            } else {
                throw new Exception("Invalid session data");
            }
        }
    } else {
        throw new Exception("Missing required data");
    }
} catch(Exception $e) {
    $response["status"] = "error";
    $response["message"] = $e->getMessage();
    http_response_code(401);
}

echo json_encode($response);