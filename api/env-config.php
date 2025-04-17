<?php
// Load environment variables from .env file
function loadEnv() {
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Parse environment variables
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            // Set as environment variable
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}

// Load environment variables
loadEnv();

// Only expose specific variables to the frontend
$safeConfig = [
    'GEMINI_API_KEY' => getenv('GEMINI_API_KEY') ?: ''
];

// Set content type to JSON
header('Content-Type: application/json');

// Return the configuration
echo json_encode($safeConfig);
