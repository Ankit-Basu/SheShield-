<?php
// Script to organize PHP files into appropriate folders

// Define the base directory
$baseDir = __DIR__;

// Define the folder structure
$folders = [
    'auth' => ['api/auth/login.php', 'api/auth/logout.php', 'api/auth/signup.php', 'api/auth/verify_session.php'],
    'incidents' => ['api/incidents/create.php', 'api/incidents/list.php', 'api/incidents/submit_report.php', 'api/incidents/update_status.php', 'fetch_incidents.php', 'mark_case_resolved.php', 'resolve-incident.php', 'update_status.php'],
    'location' => ['location.js', 'locations.js', 'map.php', 'request_location.php', 'share_location.php'],
    'safespace' => ['draw_safe_zone.php', 'get_safe_spaces.php', 'safespace.js', 'safespace.php', 'save_safe_space.php', 'save_safe_zone.php', 'save_safespace.php'],
    'emergency' => ['emergency_handler.php', 'send_sms.php', 'test_sms.php'],
    'escort' => ['get_escort.php', 'register_volunteer_handler.php', 'test_escort_email.php', 'walkwithus.php'],
    'utils' => ['fetch.php', 'test_email.php'],
    'database' => ['db.php', 'mysqli_db.php', 'pdo_db.php', 'setup_database.php']
];

// Create folders if they don't exist
foreach ($folders as $folder => $files) {
    $folderPath = $baseDir . '/' . $folder;
    if (!file_exists($folderPath)) {
        if (mkdir($folderPath, 0777, true)) {
            echo "Created directory: $folder\n";
        } else {
            echo "Failed to create directory: $folder\n";
            continue;
        }
    }
}

// Move files to their respective folders
foreach ($folders as $folder => $files) {
    foreach ($files as $file) {
        $sourcePath = $baseDir . '/' . $file;
        $fileName = basename($file);
        $destPath = $baseDir . '/' . $folder . '/' . $fileName;
        
        // Check if source file exists
        if (file_exists($sourcePath)) {
            // Create a copy of the file in the new location
            if (copy($sourcePath, $destPath)) {
                echo "Copied $file to $folder/$fileName\n";
                // Don't delete the original files to avoid breaking existing references
                // We'll let the user manually delete them after testing the new structure
            } else {
                echo "Failed to copy $file to $folder/$fileName\n";
            }
        } else {
            echo "Source file not found: $file\n";
        }
    }
}

echo "\nFile organization complete. Please test the application with the new structure before removing the original files.\n";
echo "After testing, you can manually delete the original files if everything works correctly.\n";
?>