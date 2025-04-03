<?php
require_once '../utils/session.php';

// Destroy the session
Session::destroy();

// Redirect to home page
header('Location: ../pro/index.html');
exit();
?>
