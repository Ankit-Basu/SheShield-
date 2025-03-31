<?php
require_once '../../utils/session.php';

// Destroy the session
Session::destroy();

// Redirect to login page
header('Location: ../../login.html');
exit();
?>
