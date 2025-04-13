<?php
require_once 'mysqli_db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header('Location: auth/login.php');
    exit();
}

// Get user_id and ensure it's an integer
$user_id = (int)$_SESSION['user_id'];

// Verify user exists in the database
$check_user = $conn->prepare("SELECT id FROM users WHERE id = ?");
$check_user->bind_param("i", $user_id);
$check_user->execute();
$result = $check_user->get_result();

if ($result->num_rows === 0) {
    // User doesn't exist in the database
    session_destroy();
    header('Location: auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required = ['incident_type', 'description', 'date', 'time'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "$field is required";
        }
    }

    if (!empty($errors)) {
        die(implode("\n", $errors));
    }

    // Sanitize input data
    $incident_type = $_POST['incident_type'];
    $description = $_POST['description'];
    $incident_date = $_POST['date'];
    $incident_time = $_POST['time'];
    $email = isset($_POST['email']) ? $_POST['email'] : 'anonymous@example.com';
    $location_name = isset($_POST['location']) ? $_POST['location'] : 'Unknown';

    // Combine date and time into a single datetime value
    $date_time = $incident_date . ' ' . $incident_time;
    
    // Get latitude and longitude if available
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : NULL;
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : NULL;
    
    // Insert into database (without latitude and longitude since they don't exist in the table)
    $stmt = $conn->prepare("INSERT INTO incidents (user_id, incident_type, description, location, date_time, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issss", $user_id, $incident_type, $description, $location_name, $date_time);

// Execute the statement
if ($stmt->execute()) {
    header('Location: map.php');
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();

    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Incident - Trae AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link href="/src/trae-theme.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1E1E2E 0%, #2E2E4E 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Main Content Container */
        #mainContent {
            max-width: 100%;
            overflow-x: hidden !important;
            padding: 2.5rem;
            transition: all 0.3s ease-in-out;
        }
        
        .grid {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .glass-card {
            background: rgba(46, 46, 78, 0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(74, 30, 115, 0.25);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            transition: all 0.3s ease;
            width: 100%;
            max-width: 100%;
        }
        
        .form-container {
            max-height: none;
            overflow-y: hidden;
        }
        
        /* Glassmorphic Effects */
        .glass-effect {
            background: rgba(46, 46, 78, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(74, 30, 115, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        
        .sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity;
            background: rgba(46, 46, 78, 0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-right: 1px solid rgba(74, 30, 115, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            height: 100vh;
            overflow-y: auto;
        }
        
        .glass-card {
            background: rgba(46, 46, 78, 0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(74, 30, 115, 0.25);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            transition: all 0.3s ease;
        }
        
        .trae-sidebar-item {
            transition: all 0.3s ease;
            border: 1px solid transparent;
            background: rgba(46, 46, 78, 0.2);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .trae-sidebar-item.active {
            background: linear-gradient(135deg, rgba(74, 30, 115, 0.5), rgba(215, 109, 119, 0.5));
            border: 1px solid rgba(215, 109, 119, 0.3);
        }
        
        .trae-sidebar-item:hover {
            background: rgba(215, 109, 119, 0.15);
            border: 1px solid rgba(215, 109, 119, 0.2);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .form-input:focus {
            outline: none;
            border-color: rgba(215, 109, 119, 0.7);
            box-shadow: 0 0 0 3px rgba(74, 30, 115, 0.3);
            background: rgba(46, 46, 78, 0.3);
        }
        
        .form-input {
            background: rgba(30, 30, 46, 0.6);
            border: 1px solid rgba(74, 30, 115, 0.3);
            color: #F0F0F0;
            transition: all 0.3s ease;
        }
        
        #searchResults {
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid rgba(74, 30, 115, 0.3);
            background: rgba(30, 30, 46, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        #searchResults div {
            transition: all 0.2s;
        }
        
        #searchResults div:hover {
            background: rgba(215, 109, 119, 0.2);
        }
        
        .main-container {
            height: 100vh;
            overflow-y: hidden;
        }
        
        .form-container {
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
        }
        
        /* Animations */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse-slow {
            0% { opacity: 0.7; }
            50% { opacity: 0.9; }
            100% { opacity: 0.7; }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        
        .animate-pulse-slow {
            animation: pulse-slow 8s ease-in-out infinite;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(46, 46, 78, 0.3);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(74, 30, 115, 0.7), rgba(215, 109, 119, 0.7));
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(74, 30, 115, 0.9), rgba(215, 109, 119, 0.9));
        }
        
        /* Responsive sidebar behavior */
        .sidebar-hidden { 
            transform: translateX(-100%);
            opacity: 0;
        }
        .sidebar-visible { 
            transform: translateX(0);
            opacity: 1;
        }
        .toggle-moved {
            transform: translateX(16rem) translateY(-50%);
            transition: transform 0.3s ease-in-out;
        }
        .toggle-default {
            transform: translateX(0) translateY(-50%);
            transition: transform 0.3s ease-in-out;
        }
        .content-shifted {
            margin-left: 16rem;
            transition: margin-left 0.3s ease-in-out;
        }
        .content-full {
            margin-left: 0;
            transition: margin-left 0.3s ease-in-out;
        }
        #sidebarToggle {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.33); }
            80%, 100% { opacity: 0; }
        }
        .emergency-pulse::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #ef4444;
            animation: pulse-ring 1.25s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        .number-hover {
            transition: all 0.3s ease;
        }
        .number-hover:hover {
            transform: translateX(4px);
        }
    </style>
</head>
<body class="text-[#F0F0F0] fixed inset-0 overflow-hidden">
    <!-- Background gradient shapes -->
    <div class="absolute -top-[300px] -right-[300px] w-[600px] h-[600px] bg-gradient-to-r from-[rgba(74,30,115,0.3)] to-[rgba(215,109,119,0.3)] rounded-full blur-3xl -z-10 animate-pulse-slow"></div>
    <div class="absolute -bottom-[200px] -left-[200px] w-[500px] h-[500px] bg-gradient-to-r from-[rgba(215,109,119,0.2)] to-[rgba(74,30,115,0.2)] rounded-full blur-3xl -z-10 animate-pulse-slow opacity-70"></div>
    <!-- Main container -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed w-64 text-white p-5 flex flex-col h-full z-40 sidebar-visible">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-4 w-full">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#4A1E73] to-[#D76D77] flex items-center justify-center overflow-hidden flex-shrink-0">
                        <?php
                        require_once 'includes/profile_image_handler.php';
                        $profileImage = null;
                        if (isset($_SESSION['user_id'])) {
                            $profileImage = getProfileImage($_SESSION['user_id']);
                        }
                        if ($profileImage) {
                            echo '<img src="' . htmlspecialchars($profileImage) . '" class="w-full h-full object-cover profile-image" alt="Profile Picture">';
                        } else {
                            echo '<i class="fa-solid fa-user text-xl text-white"></i>';
                        }
                        ?>
                    </div>
                    <div class="flex-grow">
                        <span class="text-lg font-bold text-gradient"><?php 
                        if (!isset($_SESSION)) { session_start(); }
                        $firstName = isset($_SESSION['first_name']) ? trim(htmlspecialchars($_SESSION['first_name'])) : '';
                        $lastName = isset($_SESSION['last_name']) ? trim(htmlspecialchars($_SESSION['last_name'])) : '';
                        echo !empty($firstName) || !empty($lastName) ? "$firstName $lastName" : 'User Name';
                        ?></span>
                    </div>
                </div>
            </div>
            <nav>
                <ul>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <a href="dashboard.php" class="w-full"><i class="fa-solid fa-house"></i> <span>Home</span></a>
                    </li>
                    <li class="trae-sidebar-item active p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <a href="report.php" class="w-full"><i class="fa-solid fa-file"></i> <span>Report</span></a>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <a href="analytics.php" class="w-full"><i class="fa-solid fa-chart-bar"></i> <span>Analytics</span></a>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <a href="map.php" class="w-full"><i class="fa-solid fa-map"></i> <span>Map</span></a>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <a href="safespace.php" class="w-full"><i class="fa-solid fa-shield-heart"></i> <span>Safe Space</span></a>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <a href="walkwithus.php" class="w-full"><i class="fa-solid fa-person-walking"></i> <span>Walk With Us</span></a>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <a href="templates.php" class="w-full"><i class="fa-solid fa-file-lines"></i> <span>Templates</span></a>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <a href="settings.php" class="w-full"><i class="fa-solid fa-gear"></i> <span>Settings</span></a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="fixed left-0 top-1/2 glass-effect bg-gradient-to-r from-[rgba(74,30,115,0.5)] to-[rgba(215,109,119,0.5)] text-white p-3 rounded-r z-50 toggle-moved hover:shadow-lg">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-10  content-shifted overflow-y-auto h-screen">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6 animate-fade-in">
                <!-- Report Form Tile -->
                <div class="glass-card p-8 rounded-xl shadow-lg form-container">
                    <h1 class="text-2xl font-bold mb-6 text-gradient text-center">Report a Safety Incident</h1>
                    <form action="" method="POST" class="space-y-6">
                        <!-- Form fields remain unchanged -->
                        <form action="" method="POST" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-[#FF9B9B] mb-2">Email</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-3 flex items-center text-[#FF9B9B]">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    placeholder="Enter your email" 
                                    class="w-full pl-10 p-3 rounded-md form-input glass-effect border-none"
                                    required
                                >
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-[#FF9B9B] mb-2">Date</label>
                                <div class="relative">
                                    <span class="absolute top-3 left-0 pl-3 flex items-center text-[#FF9B9B]">
                                        <i class="fa-solid fa-calendar"></i>
                                    </span>
                                    <input 
                                        type="date" 
                                        name="date" 
                                        class="w-full pl-10 p-3 rounded-md form-input glass-effect border-none"
                                        required
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-[#FF9B9B] mb-2">Time</label>
                                <div class="relative">
                                    <span class="absolute top-3 left-0 pl-3 flex items-center text-[#FF9B9B]">
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                    <input 
                                        type="time" 
                                        name="time" 
                                        class="w-full pl-10 p-3 rounded-md form-input glass-effect border-none"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#FF9B9B] mb-2">Incident Type</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-3 flex items-center text-[#FF9B9B]">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </span>
                                <select 
                                    name="incident_type" 
                                    class="w-full pl-10 p-3 rounded-md form-input glass-effect border-none text-[#F0F0F0]"
                                    required
                                >
                                    <option value="" class="bg-[#1E1E2E] text-[#F0F0F0]">Select incident type</option>
                                    <option value="harassment" class="bg-[#1E1E2E] text-[#F0F0F0]">Harassment</option>
                                    <option value="stalking" class="bg-[#1E1E2E] text-[#F0F0F0]">Stalking</option>
                                    <option value="theft" class="bg-[#1E1E2E] text-[#F0F0F0]">Theft</option>
                                    <option value="assault" class="bg-[#1E1E2E] text-[#F0F0F0]">Assault</option>
                                    <option value="other" class="bg-[#1E1E2E] text-[#F0F0F0]">Other</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#FF9B9B] mb-2">Location</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-3 flex items-center text-[#FF9B9B]">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>
                                <input 
                                    id="locationInput"
                                    type="text" 
                                    name="location" 
                                    placeholder="Start typing to search location..." 
                                    class="w-full pl-10 p-3 rounded-md form-input glass-effect border-none" 
                                    required
                                >
                                <div id="searchResults" class="absolute w-full mt-1 rounded-md shadow-lg hidden glass-effect"></div>
                            </div>
                            <!-- Hidden fields for coordinates -->
                            <input type="hidden" name="latitude" id="latitude" value="">
                            <input type="hidden" name="longitude" id="longitude" value="">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#FF9B9B] mb-2">Description</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-3 flex items-center text-[#FF9B9B]">
                                    <i class="fa-solid fa-pen"></i>
                                </span>
                                <textarea 
                                    name="description" 
                                    placeholder="Describe what happened..."
                                    class="w-full pl-10 p-3 rounded-md h-24 form-input glass-effect border-none" 
                                    required
                                ></textarea>
                            </div>
                        </div>
                        <div class="flex justify-center pt-4">
                            <button type="submit" class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:from-[#5A2E83] hover:to-[#E77D87] text-white px-8 py-3 rounded-lg transition-all duration-300 hover:shadow-lg transform hover:scale-[1.02] flex items-center space-x-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Submit Report</span>
                            </button>
                        </div>
                    </form>
                        <!-- ... previous form fields ... -->
                    </form>
                </div>

                <!-- Emergency Response Center -->
                <div class="glass-card p-6 rounded-xl shadow-lg sticky top-10 space-y-4 animate-fade-in">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-bold text-[#FF9B9B] flex items-center">
                            <i class="fa-solid fa-phone-volume mr-2"></i>
                            Emergency Response
                        </h2>
                        <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full text-xs animate-pulse">
                            24/7 Active
                        </span>
                    </div>

                    <!-- SOS Button -->
                    <button onclick="activateSOS()" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white p-2.5 rounded-lg transition-all duration-300 transform hover:scale-[1.02] relative overflow-hidden group">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-10 h-10 bg-red-500 rounded-full opacity-25 animate-ping"></div>
                        </div>
                        <div class="relative flex flex-col items-center space-y-0.5">
                            <i class="fa-solid fa-bell text-lg"></i>
                            <span class="text-sm font-bold">ACTIVATE SOS</span>
                            <span class="text-xs opacity-90">Instant Security Alert</span>
                        </div>
                    </button>

                    <!-- Emergency Contacts -->
                    <div class="space-y-2">
                        <!-- LPU Security -->
                                               <!-- LPU Security -->
                                               <div class="p-3 glass-effect rounded-lg hover:shadow-md transition-all duration-300 border border-[rgba(215,109,119,0.2)] group hover:border-[rgba(215,109,119,0.4)] hover:translate-y-[-2px])">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-white text-xs">LPU Security Control Room</h3>
                                <div class="flex space-x-1">
                                    <button onclick="copyNumber('1800-102-4431')" class="text-[#FF9B9B] hover:text-[#FF7B7B] p-1">
                                        <i class="fa-regular fa-copy text-xs"></i>
                                    </button>
                                    <button onclick="sendEmergencyAlert('LPU Security', '1800-102-4431')" class="text-[#FF9B9B] hover:text-[#FF7B7B] p-1">
                                        <i class="fa-solid fa-bell text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="number-hover">
                                <p class="text-sm font-bold text-[#FF9B9B]">1800-102-4431</p>
                                <span class="text-xs text-[#FF9B9B] opacity-80">Click bell for instant alert</span>
                            </div>
                        </div>
                        <!-- Campus Emergency -->
                        <div class="p-3 glass-effect rounded-lg hover:shadow-md transition-all duration-300 border border-[rgba(215,109,119,0.2)] group hover:border-[rgba(215,109,119,0.4)] hover:translate-y-[-2px])">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-white text-xs">Campus Emergency</h3>
                                <div class="flex space-x-1">
                                    <button onclick="copyNumber('+91-1824-517000')" class="text-[#D12E79] hover:text-[#AB1E5C] p-1">
                                        <i class="fa-regular fa-copy text-xs"></i>
                                    </button>
                                    <button onclick="sendEmergencyAlert('Campus Medical', '+91-1824-517000')" class="text-[#D12E79] hover:text-[#AB1E5C] p-1">
                                        <i class="fa-solid fa-bell text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="number-hover">
                                <p class="text-sm font-bold text-[#FF9B9B]">+91-1824-517000</p>
                                <span class="text-xs text-[#FF9B9B] opacity-80">Click bell for medical alert</span>
                            </div>
                        </div>

                        <!-- Women Helpline -->
                        <div class="p-3 glass-effect rounded-lg hover:shadow-md transition-all duration-300 border border-[rgba(215,109,119,0.2)] group hover:border-[rgba(215,109,119,0.4)] hover:translate-y-[-2px])">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-white text-xs">Women Helpline</h3>
                                <div class="flex space-x-1">
                                    <button onclick="copyNumber('1091')" class="text-[#D12E79] hover:text-[#AB1E5C] p-1">
                                        <i class="fa-regular fa-copy text-xs"></i>
                                    </button>
                                    <button onclick="sendEmergencyAlert('Women Helpline', '1091')" class="text-[#D12E79] hover:text-[#AB1E5C] p-1">
                                        <i class="fa-solid fa-bell text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="number-hover">
                                <p class="text-sm font-bold text-[#FF9B9B]">1091</p>
                                <span class="text-xs text-[#FF9B9B] opacity-80">Click bell for immediate assistance</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <button onclick="shareLocation()" class="p-2 bg-gradient-to-r from-[rgba(74,30,115,0.7)] to-[rgba(215,109,119,0.7)] rounded-lg hover:from-[rgba(74,30,115,0.8)] hover:to-[rgba(215,109,119,0.8)] transition-all text-center group">
                                <i class="fa-solid fa-location-dot text-white text-sm group-hover:scale-110 transition-transform"></i>
                                <p class="text-xs font-medium mt-1 text-white">Share Location</p>
                            </button>
                            <button onclick="startLiveStream()" class="p-2 bg-gradient-to-r from-[rgba(74,30,115,0.7)] to-[rgba(215,109,119,0.7)] rounded-lg hover:from-[rgba(74,30,115,0.8)] hover:to-[rgba(215,109,119,0.8)] transition-all text-center group">
                                <i class="fa-solid fa-video text-white text-sm group-hover:scale-110 transition-transform"></i>
                                <p class="text-xs font-medium mt-1 text-white">Live Stream</p>
                            </button>
                        </div>

                        <!-- Safety Tips & Emergency Button -->
                        <div class="p-2 glass-effect rounded-lg border border-[rgba(215,109,119,0.2)] mt-3 hover:border-[rgba(215,109,119,0.4)] transition-all duration-300">
                            <h3 class="font-semibold text-[#FF9B9B] flex items-center text-xs mb-1">
                                <i class="fa-solid fa-shield-heart mr-2 text-[#D12E79]"></i>
                                Safety Tips
                            </h3>
                            <div id="safetyTips" class="text-sm text-white font-medium mb-2"></div>
                            
                            <!-- Emergency SOS Button -->
                            <button onclick="activateSOS()" class="w-full mt-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-4 py-2 rounded-lg transition-all duration-300 flex items-center justify-center space-x-2 transform hover:scale-[1.02]">
                                <div class="relative h-5 w-5 emergency-pulse bg-white rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-xs"></i>
                                </div>
                                <span class="font-bold">EMERGENCY SOS</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.trae-sidebar');
            const mainContent = document.querySelector('.content-shifted');
            const toggleButton = document.querySelector('#sidebarToggle');
    
            function toggleSidebar() {
                sidebar.classList.toggle('sidebar-hidden');
                sidebar.classList.toggle('sidebar-visible');
                mainContent.classList.toggle('content-shifted');
                mainContent.classList.toggle('content-full');
                toggleButton.classList.toggle('toggle-moved');
                toggleButton.classList.toggle('toggle-default');
            }
    
            toggleButton.addEventListener('click', toggleSidebar);
    
            // Handle initial state for mobile devices
            if (window.innerWidth < 768) {
                sidebar.classList.add('sidebar-hidden');
                sidebar.classList.remove('sidebar-visible');
                mainContent.classList.remove('content-shifted');
                mainContent.classList.add('content-full');
                toggleButton.classList.remove('toggle-moved');
                toggleButton.classList.add('toggle-default');
            }
        });
<<<<<<< HEAD
    
=======
    </script>
    
    <script>
>>>>>>> bda333ed907adf701cb0e508d27ebf33a5ae623f
    function sendEmergencyAlert(team, number) {
    if ("geolocation" in navigator) {
        showNotification('info', `Alerting ${team}...`);
        
        navigator.geolocation.getCurrentPosition(function(position) {
            const emergencyData = {
                team: team,
                number: number,
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                timestamp: new Date().toISOString()
            };

            fetch('emergency_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(emergencyData)
            })
            .then(response => response.json())
            .then(data => {
                showNotification('success', `${team} has been notified and is responding`);
                // Add redirect after notification
                setTimeout(() => {
                }, 1500); // Wait 1.5 seconds so user can see the notification
            })
            .catch(error => {
                showNotification('error', 'Unable to send alert');
            });
        });
    } else {
        showNotification('error', 'Location access needed for emergency alert');
    }
}


    function activateSOS() {
        // Create confirmation dialog
        const confirmDialog = document.createElement('div');
        confirmDialog.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        confirmDialog.innerHTML = `
            <div class="bg-gradient-to-r from-[#1E1E2E] to-[#2E2E4E] p-6 rounded-xl shadow-lg max-w-md w-full glass-effect border border-[rgba(215,109,119,0.3)]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-[#FF9B9B]">Emergency SOS</h3>
                    <div class="relative h-8 w-8 emergency-pulse bg-red-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div>
                <p class="text-white mb-6">Are you sure you want to activate the emergency SOS? This will alert emergency services and share your location.</p>
                <div class="flex justify-between">
                    <button id="cancelSOS" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded transition-colors">Cancel</button>
                    <button id="confirmSOS" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded transition-colors">Activate SOS</button>
                </div>
            </div>
        `;
        document.body.appendChild(confirmDialog);

        // Handle cancel button
        document.getElementById('cancelSOS').addEventListener('click', function() {
            confirmDialog.remove();
        });

        // Handle confirm button
        document.getElementById('confirmSOS').addEventListener('click', function() {
            confirmDialog.remove();
            sendSOSAlert(); // Directly call sendSOSAlert without countdown
        });
    }

    function sendSOSAlert() {
        if ("geolocation" in navigator) {
            showNotification('info', 'Getting your location...');
            
            // Options for better geolocation accuracy
            const options = {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            };
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    showNotification('info', 'Preparing WhatsApp link...');
                    
                    // Get coordinates
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    // Create a detailed emergency message with Google Maps link
                    const currentTime = new Date().toLocaleTimeString();
                    const currentDate = new Date().toLocaleDateString();
                    const message = `🚨 EMERGENCY ALERT 🚨\n\nI need immediate help at this location!\n\n📍 Location: https://maps.google.com/?q=${lat},${lng}\n\n⏰ Sent at: ${currentTime} on ${currentDate}\n\nPlease contact emergency services if you receive this message.`;
                    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
                    
                    // Create status dialog with WhatsApp sharing option
                    const statusDialog = document.createElement('div');
                    statusDialog.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                    statusDialog.innerHTML = `
                        <div class="bg-gradient-to-r from-[#1E1E2E] to-[#2E2E4E] p-6 rounded-xl shadow-lg max-w-md w-full glass-effect border border-[rgba(215,109,119,0.3)]">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-[#FF9B9B]">Emergency Response</h3>
                                <div class="relative h-8 w-8 emergency-pulse bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <p class="text-white mb-4">Your location is ready to share.</p>
                            <div class="bg-gray-800 p-3 rounded mb-4">
                                <p class="text-sm text-white"><i class="fas fa-map-marker-alt text-[#FF9B9B] mr-2"></i>Your coordinates: ${lat.toFixed(6)}, ${lng.toFixed(6)}</p>
                            </div>
                            <div class="flex flex-col space-y-3">
                                <button id="shareWhatsApp" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition-colors"><i class="fab fa-whatsapp mr-2"></i>Share Location via WhatsApp</button>
                                <div class="flex justify-between">
                                    <button id="callEmergency" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors"><i class="fas fa-phone mr-2"></i>Call Emergency</button>
                                    <button id="closeStatus" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded transition-colors">Close</button>
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(statusDialog);
                    
                    // Handle WhatsApp share button - direct WhatsApp sharing
                    document.getElementById('shareWhatsApp').addEventListener('click', function() {
                        window.open(whatsappUrl, '_blank');
                        showNotification('success', 'Opening WhatsApp to share your location');
                    });
                    
                    // Handle call emergency button
                    document.getElementById('callEmergency').addEventListener('click', function() {
                        window.location.href = 'tel:1800-102-4431';
                    });
                    
                    // Handle close button
                    document.getElementById('closeStatus').addEventListener('click', function() {
                        statusDialog.remove();
                    });

<<<<<<< HEAD
            navigator.geolocation.getCurrentPosition(function(position) {
                const locationData = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                };

                showNotification('info', 'Sending location...');

                fetch('share_location.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(locationData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('success', data.message);
                    } else {
                        showNotification('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Failed to share location');
                });
            }, 
            function(error) {
                console.error('Geolocation error:', error);
                showNotification('error', 'Please enable location access to share your location.');
            });
        }      function startLiveStream() {
            const streamWindow = window.open('live_stream.php', 'SheShield Live Stream', 'width=800,height=600,menubar=no,toolbar=no,location=no,status=no');
            if (streamWindow) {
                streamWindow.focus();
            } else {
                showNotification('error', 'Please allow pop-ups to start live stream');
            }
=======
                    // Also send alert to server in the background
                    const emergencyData = {
                        latitude: lat,
                        longitude: lng,
                        timestamp: new Date().toISOString()
                    };
                    
                    fetch('emergency_handler.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(emergencyData)
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                },
                function(error) {
                    console.error('Geolocation error:', error);
                    showNotification('error', 'Please enable location access for emergency services.');
                    setTimeout(() => {
                        window.location.href = 'tel:1800-102-4431';
                    }, 1500);
                },
                options
            );
        } else {
            showNotification('error', 'Your device does not support location services.');
            setTimeout(() => {
                window.location.href = 'tel:1800-102-4431';
            }, 1500);
>>>>>>> bda333ed907adf701cb0e508d27ebf33a5ae623f
        }
    }
    function copyNumber(number) {
        navigator.clipboard.writeText(number).then(() => {
            alert('Number copied to clipboard!');
        });
    }

    function shareLocation() {
        if (!("geolocation" in navigator)) {
            showNotification('error', 'Your browser doesn\'t support location sharing.');
            return;
        }

        showNotification('info', 'Getting your location...');

        // Add options for better geolocation accuracy
        const options = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        };

        navigator.geolocation.getCurrentPosition(function(position) {
            const locationData = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            };

            showNotification('info', 'Sending location...');

            fetch('share_location.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(locationData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message);
                } else {
                    showNotification('error', data.message || 'Failed to share location');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Failed to share location: ' + error.message);
            });
        }, 
        function(error) {
            console.error('Geolocation error:', error);
            let errorMsg = 'Please enable location access to share your location.';
            
            // Provide more specific error messages
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMsg = 'Location permission denied. Please enable location access in your browser settings.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMsg = 'Location information is unavailable. Please try again later.';
                    break;
                case error.TIMEOUT:
                    errorMsg = 'Location request timed out. Please try again.';
                    break;
            }
            
            showNotification('error', errorMsg);
        }, options);
    }
        
    function startLiveStream() {
        showNotification('info', 'Starting live stream...');
        
        // Check if browser supports getUserMedia before opening the window
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showNotification('error', 'Your browser does not support webcam access');
            return;
        }
        
        // Request camera permission first
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                // Stop the stream immediately, we just needed to check permission
                stream.getTracks().forEach(track => track.stop());
                
                // Now open the live stream window
                const streamWindow = window.open('live_stream.php', 'SheShield Live Stream', 'width=800,height=600,menubar=no,toolbar=no,location=no,status=no');
                if (streamWindow) {
                    streamWindow.focus();
                    showNotification('success', 'Live stream started');
                } else {
                    showNotification('error', 'Please allow pop-ups to start live stream');
                }
            })
            .catch(err => {
                console.error('Camera access error:', err);
                showNotification('error', 'Camera access denied. Please allow camera access in your browser settings.');
            });
    }

        // Safety Tips Rotation
        const tips = [
            "Stay in well-lit areas at night",
            "Keep emergency contacts on speed dial",
            "Use buddy system when possible",
            "Trust your instincts"
        ];
        let currentTip = 0;
        
        function rotateTips() {
            document.getElementById('safetyTips').textContent = tips[currentTip];
            currentTip = (currentTip + 1) % tips.length;
        }

        rotateTips();
        setInterval(rotateTips, 5000);

        function showNotification(type, message) {
    const colors = {
        success: 'bg-green-100 border-green-400 text-green-700',
        error: 'bg-red-100 border-red-400 text-red-700',
        info: 'bg-blue-100 border-blue-400 text-blue-700'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} px-4 py-3 rounded z-50 flex items-center`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle mr-2"></i>
        <span>${message}</span>
    `;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
    </script>

    <script>
<<<<<<< HEAD
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        let isSidebarVisible = true;
    
        sidebarToggle.addEventListener('click', function() {
            isSidebarVisible = !isSidebarVisible;
            sidebar.classList.toggle('sidebar-hidden');
            sidebar.classList.toggle('sidebar-visible');
            mainContent.classList.toggle('content-shifted');
            mainContent.classList.toggle('content-full');
            sidebarToggle.classList.toggle('toggle-moved');
            sidebarToggle.classList.toggle('toggle-default');
        });
    });
    </script>
    </body>
    </html>

    <script src="sidebar.js"></script>
=======
        // Location handling for the report form
        document.addEventListener('DOMContentLoaded', function() {
            const locationInput = document.getElementById('locationInput');
            const searchResults = document.getElementById('searchResults');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            
            // Get current location when the page loads
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Store coordinates in hidden fields
                    latitudeInput.value = position.coords.latitude;
                    longitudeInput.value = position.coords.longitude;
                    
                    // Reverse geocode to get location name
                    reverseGeocode(position.coords.latitude, position.coords.longitude);
                }, function(error) {
                    console.error("Error getting location:", error);
                });
            }
            
            // Function to reverse geocode coordinates to address
            function reverseGeocode(lat, lng) {
                // This is a simple example - in a real app, you might use a geocoding service
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            locationInput.value = data.display_name;
                        }
                    })
                    .catch(error => console.error("Reverse geocoding error:", error));
            }
            
            // When user selects a location from search results
            searchResults.addEventListener('click', function(e) {
                if (e.target && e.target.dataset.lat && e.target.dataset.lng) {
                    // Update hidden fields with coordinates
                    latitudeInput.value = e.target.dataset.lat;
                    longitudeInput.value = e.target.dataset.lng;
                    
                    // Update location input with selected location name
                    locationInput.value = e.target.textContent;
                    
                    // Hide search results
                    searchResults.classList.add('hidden');
                }
            });
        });
    </script>

>>>>>>> bda333ed907adf701cb0e508d27ebf33a5ae623f
    <script src="location.js"></script>
</body>
</html>
