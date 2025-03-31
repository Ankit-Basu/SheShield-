<?php
require_once 'mysqli_db.php';

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
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO incidents (incident_type, description, location, date_time, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssss", $incident_type, $description, $location_name, $date_time);

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
    <title>Report Safety Incident - LPU Campus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .sidebar-hidden { transform: translateX(-100%); }
        .sidebar-visible { transform: translateX(0); }
        .toggle-moved { transform: translateX(16rem) translateY(-50%); }
        .toggle-default { transform: translateX(0) translateY(-50%); }
        .content-shifted { margin-left: 16rem; }
        .content-full { margin-left: 0; }
        .form-input:focus {
            outline: none;
            border-color: #D12E79;
            box-shadow: 0 0 0 3px rgba(209, 46, 121, 0.1);
        }
        #searchResults {
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #e5e7eb;
        }
        #searchResults div {
            transition: all 0.2s;
        }
        #searchResults div:hover {
            background-color: #FDF2F8;
        }
        body {
            min-height: 100vh;
            overflow-y: auto;
        }
        .main-container {
            height: 100vh;
            overflow-y: auto;
        }
        .form-container {
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
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
<body class="bg-gray-100 text-gray-900">
    <!-- Main container -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed w-64 bg-[#D12E79] text-white p-5 flex flex-col h-full z-40 transition-transform duration-300 ease-in-out sidebar-visible">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-shield-halved text-3xl"></i>
                    <span class="text-lg font-bold"><?php 
                    if (!isset($_SESSION)) { session_start(); }
                    echo isset($_SESSION['first_name']) ? 'Welcome ' . htmlspecialchars($_SESSION['first_name']) : 'User Name'; 
                    ?></span>
                </div>
            </div>
            <nav>
                <ul>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <a href="home.php"><i class="fa-solid fa-house"></i> <span>Home</span></a>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <a href="report.php"><i class="fa-solid fa-file"></i> <span>Report</span></a>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <i class="fa-solid fa-chart-bar"></i> <span>Analytics</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <a href="map.php"><i class="fa-solid fa-map"></i> <span>Map</span></a>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='safespace.php'">
                        <i class="fa-solid fa-shield-heart"></i> <span>Safe Space</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='walkwithus.php'">
                        <i class="fa-solid fa-person-walking"></i> <span>Walk With Us</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='templates.php'">
                        <i class="fa-solid fa-file-lines"></i> <span>Templates</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <a href="settings.php"><i class="fa-solid fa-gear"></i> <span>Settings</span></a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="fixed left-0 top-1/2 bg-[#D12E79] text-white p-2 rounded-r z-50 transition-transform duration-300 ease-in-out toggle-moved">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-10 transition-all duration-300 ease-in-out content-shifted overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Report Form Tile -->
                <div class="bg-white p-8 rounded-lg shadow-lg form-container">
                    <h1 class="text-2xl font-bold mb-6 text-[#D12E79] text-center">Report a Safety Incident</h1>
                    <form action="" method="POST" class="space-y-6">
                        <!-- Form fields remain unchanged -->
                        <form action="" method="POST" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    placeholder="Enter your email" 
                                    class="w-full pl-10 p-3 border border-gray-300 rounded-md form-input"
                                    required
                                >
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
                                <div class="relative">
                                    <span class="absolute top-3 left-0 pl-3 flex items-center text-gray-500">
                                        <i class="fa-solid fa-calendar"></i>
                                    </span>
                                    <input 
                                        type="date" 
                                        name="date" 
                                        class="w-full pl-10 p-3 border border-gray-300 rounded-md form-input"
                                        required
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Time</label>
                                <div class="relative">
                                    <span class="absolute top-3 left-0 pl-3 flex items-center text-gray-500">
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                    <input 
                                        type="time" 
                                        name="time" 
                                        class="w-full pl-10 p-3 border border-gray-300 rounded-md form-input"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Incident Type</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </span>
                                <select 
                                    name="incident_type" 
                                    class="w-full pl-10 p-3 border border-gray-300 rounded-md form-input"
                                    required
                                >
                                    <option value="">Select incident type</option>
                                    <option value="harassment">Harassment</option>
                                    <option value="stalking">Stalking</option>
                                    <option value="theft">Theft</option>
                                    <option value="assault">Assault</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>
                                <input 
                                    id="locationInput"
                                    type="text" 
                                    name="location" 
                                    placeholder="Start typing to search location..." 
                                    class="w-full pl-10 p-3 border border-gray-300 rounded-md form-input" 
                                    required
                                >
                                <div id="searchResults" class="absolute w-full bg-white mt-1 rounded-md shadow-lg hidden"></div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fa-solid fa-pen"></i>
                                </span>
                                <textarea 
                                    name="description" 
                                    placeholder="Describe what happened..."
                                    class="w-full pl-10 p-3 border border-gray-300 rounded-md h-24 form-input" 
                                    required
                                ></textarea>
                            </div>
                        </div>
                        <div class="flex justify-center pt-4">
                            <button type="submit" class="bg-[#D12E79] text-white px-8 py-3 rounded-lg hover:bg-[#AB1E5C] transition-colors duration-200 flex items-center space-x-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Submit Report</span>
                            </button>
                        </div>
                    </form>
                        <!-- ... previous form fields ... -->
                    </form>
                </div>

                <!-- Emergency Response Center -->
                <div class="bg-white p-4 rounded-lg shadow-lg sticky top-10 space-y-3">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-base font-bold text-[#D12E79] flex items-center">
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
                                               <div class="p-2 bg-gradient-to-r from-pink-50 to-red-50 rounded-lg hover:shadow-md transition-all duration-200 border border-pink-100 group">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800 text-xs">LPU Security Control Room</h3>
                                <div class="flex space-x-1">
                                    <button onclick="copyNumber('1800-102-4431')" class="text-[#D12E79] hover:text-[#AB1E5C] p-1">
                                        <i class="fa-regular fa-copy text-xs"></i>
                                    </button>
                                    <button onclick="sendEmergencyAlert('LPU Security', '1800-102-4431')" class="text-[#D12E79] hover:text-[#AB1E5C] p-1">
                                        <i class="fa-solid fa-bell text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="number-hover">
                                <p class="text-sm font-bold text-[#D12E79]">1800-102-4431</p>
                                <span class="text-xs text-gray-500">Click bell for instant alert</span>
                            </div>
                        </div>
                        <!-- Campus Emergency -->
                        <div class="p-2 bg-gradient-to-r from-pink-50 to-red-50 rounded-lg hover:shadow-md transition-all duration-200 border border-pink-100 group">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800 text-xs">Campus Emergency</h3>
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
                                <p class="text-sm font-bold text-[#D12E79]">+91-1824-517000</p>
                                <span class="text-xs text-gray-500">Click bell for medical alert</span>
                            </div>
                        </div>

                        <!-- Women Helpline -->
                        <div class="p-2 bg-gradient-to-r from-pink-50 to-red-50 rounded-lg hover:shadow-md transition-all duration-200 border border-pink-100 group">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800 text-xs">Women Helpline</h3>
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
                                <p class="text-sm font-bold text-[#D12E79]">1091</p>
                                <span class="text-xs text-gray-500">Click bell for immediate assistance</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <button onclick="shareLocation()" class="p-2 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all text-center group">
                                <i class="fa-solid fa-location-dot text-blue-600 text-sm group-hover:scale-110 transition-transform"></i>
                                <p class="text-xs font-medium mt-1">Share Location</p>
                            </button>
                            <button onclick="startLiveStream()" class="p-2 bg-purple-50 rounded-lg hover:bg-purple-100 transition-all text-center group">
                                <i class="fa-solid fa-video text-purple-600 text-sm group-hover:scale-110 transition-transform"></i>
                                <p class="text-xs font-medium mt-1">Live Stream</p>
                            </button>
                        </div>

                        <!-- Safety Tips -->
                        <div class="p-2 bg-gray-50 rounded-lg border border-gray-100 mt-3">
                            <h3 class="font-semibold text-gray-700 flex items-center text-xs mb-1">
                                <i class="fa-solid fa-shield-heart mr-2 text-[#D12E79]"></i>
                                Safety Tips
                            </h3>
                            <div id="safetyTips" class="text-xs text-gray-600"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
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
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const emergencyData = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    timestamp: new Date().toISOString()
                };

                fetch('emergency_handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(emergencyData)
                })
                .then(response => response.json())
                .then(data => {
                    alert('Emergency alert sent! Help is on the way.');
                    if (confirm('Would you like to call emergency services?')) {
                        window.location.href = 'tel:1800-102-4431';
                    }
                })
                .catch(error => {
                    alert('Unable to send alert. Calling emergency services...');
                    window.location.href = 'tel:1800-102-4431';
                });
            },
            function(error) {
                alert('Please enable location access for emergency services.');
                window.location.href = 'tel:1800-102-4431';
            }
        );
    } else {
        alert('Your device does not support location services.');
        window.location.href = 'tel:1800-102-4431';
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

    <script src="sidebar.js"></script>
    <script src="location.js"></script>
</body>
</html>
