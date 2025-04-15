<?php
session_start();

header('Content-Type: application/json');

if (!isset($_POST['field'])) {
    echo json_encode(['success' => false, 'message' => 'No field specified']);
    exit;
}

$field = $_POST['field'];
$validFields = ['security_confirmed', 'victim_safe', 'resolution_confirmed'];

if (!in_array($field, $validFields)) {
    echo json_encode(['success' => false, 'message' => 'Invalid field']);
    exit;
}

// Toggle the field's value
$_SESSION[$field] = !isset($_SESSION[$field]) || !$_SESSION[$field];

// Calculate new progress
$progress = 0;
if (isset($_SESSION['security_confirmed']) && $_SESSION['security_confirmed']) $progress += 33;
if (isset($_SESSION['victim_safe']) && $_SESSION['victim_safe']) $progress += 33;
if (isset($_SESSION['resolution_confirmed']) && $_SESSION['resolution_confirmed']) $progress += 34;

echo json_encode([
    'success' => true,
    'progress' => $progress,
    'field' => $field,
    'value' => $_SESSION[$field]
]);