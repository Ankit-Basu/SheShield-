<?php
// Email Configuration Example
// Copy this file to email_config.php and fill in your credentials
// NOTE: email_config.php should NOT be committed to the repository

// SMTP Settings
define('SMTP_HOST', 'smtp.example.com'); // e.g., smtp.gmail.com
define('SMTP_USERNAME', 'your-email@example.com'); // Your email address
define('SMTP_PASSWORD', 'your-password-or-app-password'); // Your email password or app password
define('SMTP_PORT', 465); // 465 for SSL, 587 for TLS
define('SMTP_ENCRYPTION', 'ssl'); // 'ssl' or 'tls'

// Default sender information
define('DEFAULT_FROM_EMAIL', 'your-email@example.com'); // Your email address
define('DEFAULT_FROM_NAME', 'SheShield'); // Name to display as sender