<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trae AI Dashboard</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>

    <!-- Trae AI Theme -->
    <link href="/src/trae-theme.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg, #1E1E2E 0%, #2E2E4E 100%);
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y:auto;
        }
        
        /* Glassmorphic Effects */
        .glass-effect {
            background: rgba(46, 46, 78, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(74, 30, 115, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        
        /* .trae-sidebar {
            background: rgba(46, 46, 78, 0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-right: 1px solid rgba(74, 30, 115, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        } */
        
        .trae-card {
            background: rgba(46, 46, 78, 0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(74, 30, 115, 0.25);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            transition: all 0.3s ease;
        }
        
         .trae-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(215, 109, 119, 0.3);
        } 
        
        .trae-sidebar-item {
            transition: all 0.3s ease;
            border: 1px solid transparent;
            background: rgba(46, 46, 78, 0.2);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            color: #F0F0F0;
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
            background: linear-gradient(135deg, rgba(74, 30, 115, 0.5), rgba(215, 109, 119, 0.5));
            color: #F0F0F0;
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
        
        /* Staggered animations for cards */
        .animate-fade-in > a:nth-child(1) { animation-delay: 0.1s; }
        .animate-fade-in > a:nth-child(2) { animation-delay: 0.2s; }
        .animate-fade-in > a:nth-child(3) { animation-delay: 0.3s; }
        
        /* Responsive sidebar behavior */
        
            /* #sidebar {
                transform: translateX(0);
                opacity: 1;
            } */
            /* .sidebar{
                transition: transform 0.3s ease-in-out;
                background: linear-gradient(180deg, #4A1E73 0%, #D76D77 100%);
            } */
            /* #mainContent {
                margin-left: 16rem;
            } */
            /* #sidebarToggle {
            transition: transform 0.3s ease-in-out;
            } */
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
        
    </style>
</head>
<body class="bg-[#1E1E2E] text-[#F0F0F0]">
    <div class="flex min-h-screen relative z-0">
        <!-- Background gradient shapes -->
        <div class="absolute -top-[300px] -right-[300px] w-[600px] h-[600px] bg-gradient-to-r from-[rgba(74,30,115,0.3)] to-[rgba(215,109,119,0.3)] rounded-full blur-3xl -z-10 animate-pulse-slow"></div>
        <div class="absolute -bottom-[200px] -left-[200px] w-[500px] h-[500px] bg-gradient-to-r from-[rgba(215,109,119,0.2)] to-[rgba(74,30,115,0.2)] rounded-full blur-3xl -z-10 animate-pulse-slow opacity-70"></div>
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed w-64 text-white p-5 flex flex-col h-full z-40  sidebar-visible">

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
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer active" onclick="window.location.href='dashboard.php'">
                        <i class="fa-solid fa-house"></i> <span>Home</span>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer" onclick="window.location.href='report.php'">
                        <i class="fa-solid fa-file"></i> <span>Reports</span>
                    </li>
                    <li>
                        <a href="analytics.php" class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer">
                        <i class="fa-solid fa-chart-bar"></i> <span>Analytics</span>
                        </a>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer" onclick="window.location.href='map.php'">
                        <i class="fa-solid fa-map"></i> <span>Map</span>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer" onclick="window.location.href='safespace.php'">
                        <i class="fa-solid fa-shield-heart"></i> <span>Safe Space</span>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer" onclick="window.location.href='walkwithus.php'">
                        <i class="fa-solid fa-person-walking"></i> <span>Walk With Us</span>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer" onclick="window.location.href='templates.php'">
                        <i class="fa-solid fa-file-lines"></i> <span>Templates</span>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer" onclick="window.location.href='settings.php'">
                        <i class="fa-solid fa-gear"></i> <span>Settings</span>
                    </li>
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer" onclick="window.location.href='auth/logout.php'">
                        <i class="fa-solid fa-sign-out-alt"></i> <span>Logout</span>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="fixed left-0 top-1/2 glass-effect bg-gradient-to-r from-[rgba(74,30,115,0.5)] to-[rgba(215,109,119,0.5)] text-white p-3 rounded-r z-50 toggle-moved">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-10  content-shifted">
            <div id="content">
                <h1 class="text-3xl font-bold text-gradient">Dashboard Overview</h1>
                
                <!-- Dashboard Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                    <!-- Analytics Card -->
                    <a href="analytics.php" class="block">
                        <div class="trae-card rounded-xl overflow-hidden group">
                            <div class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] h-2 group-hover:h-3 "></div>
                            <div class="p-6 relative overflow-hidden z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-xl font-semibold text-white">Analytics Dashboard</h2>
                                    <div class="glass-effect p-3 rounded-full group-hover:scale-110">
                                        <i class="fa-solid fa-chart-bar text-[#D76D77] text-xl"></i>
                                    </div>
                                </div>
                                <p class="text-[#A0A0B0] mt-4">View comprehensive analytics, case statistics, and data visualizations.</p>
                                <div class="mt-6 flex items-center text-[#D76D77] relative z-10  group-hover:translate-x-2">
                                    <span>Explore Analytics</span>
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Reports Card -->
                    <a href="report.php" class="block">
                        <div class="trae-card rounded-xl overflow-hidden group">
                            <div class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] h-2 group-hover:h-3 "></div>
                            <div class="p-6 relative overflow-hidden z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-xl font-semibold text-white">Reports</h2>
                                    <div class="glass-effect p-3 rounded-full  group-hover:scale-110">
                                        <i class="fa-solid fa-file text-[#D76D77] text-xl"></i>
                                    </div>
                                </div>
                                <p class="text-[#A0A0B0] mt-4">Access and manage incident reports and case documentation.</p>
                                <div class="mt-6 flex items-center text-[#D76D77] relative z-10  group-hover:translate-x-2">
                                    <span>View Reports</span>
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Map Card -->
                    <a href="map.php" class="block">
                        <div class="trae-card rounded-xl overflow-hidden group">
                            <div class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] h-2 group-hover:h-3 "></div>
                            <div class="p-6 relative overflow-hidden z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-xl font-semibold text-white">Safety Map</h2>
                                    <div class="glass-effect p-3 rounded-full group-hover:scale-110">
                                        <i class="fa-solid fa-map text-[#D76D77] text-xl"></i>
                                    </div>
                                </div>
                                <p class="text-[#A0A0B0] mt-4">View incident locations and safety information on an interactive map.</p>
                                <div class="mt-6 flex items-center text-[#D76D77] relative z-10 group-hover:translate-x-2">
                                    <span>Open Map</span>
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- Latest Incident Report Tile -->
                    <?php
                    require_once 'mysqli_db.php';
                    $sql = "SELECT incident_type, description, date_time, status FROM incidents WHERE user_id = ? ORDER BY date_time DESC LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $_SESSION['user_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $latest_incident = $result->fetch_assoc();
                    ?>
                    <div class="trae-card h-[500px] w-[120%] -ml-[10%] p-6 rounded-xl overflow-hidden group">
                        <div class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] h-2 group-hover:h-3"></div>
                        <div class="p-6 relative overflow-hidden z-10">
                            <div class="flex items-center justify-between mb-3">
                                <h2 class="text-xl font-semibold text-white">Latest Incident Report</h2>
                                <div class="glass-effect p-3 rounded-full group-hover:scale-110">
                                    <i class="fa-solid fa-triangle-exclamation text-[#D76D77] text-xl"></i>
                                </div>
                            </div>
                            <?php if ($latest_incident): ?>
                            <div class="mt-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[#A0A0B0]">Type:</span>
                                    <span class="text-white"><?php echo htmlspecialchars($latest_incident['incident_type']); ?></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[#A0A0B0]">Status:</span>
                                    <span class="px-2 py-1 rounded text-sm <?php echo $latest_incident['status'] === 'pending' ? 'bg-yellow-500/20 text-yellow-300' : 'bg-green-500/20 text-green-300'; ?>">
                                        <?php echo ucfirst(htmlspecialchars($latest_incident['status'])); ?>
                                    </span>
                                </div>
                                <div class="mt-4">
                                    <p class="text-[#A0A0B0] line-clamp-3"><?php echo htmlspecialchars($latest_incident['description']); ?></p>
                                </div>
                                <div class="text-sm text-[#A0A0B0] mt-4">
                                    Reported: <?php echo date('M j, Y g:i A', strtotime($latest_incident['date_time'])); ?>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="mt-4 text-center text-[#A0A0B0]">
                                <p>No incidents reported yet</p>
                            </div>
                            <?php endif; ?>
                            <a href="report.php" class="mt-6 flex items-center text-[#D76D77] relative z-10 group-hover:translate-x-2">
                                <span>View All Reports</span>
                                <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Latest Episode Card -->
                    <!-- Episode Analytics Card -->
                </div>
            </div>
        </main>
    </div>

    <script>
        class Sidebar {
            constructor() {
                this.sidebar = document.getElementById('sidebar');
                this.sidebarToggle = document.getElementById('sidebarToggle');
                this.mainContent = document.getElementById('mainContent');
                this.initializeSidebar();
            }

            initializeSidebar() {
                this.sidebarToggle.addEventListener('click', () => {
                    this.toggleSidebar();
                });
            }

            toggleSidebar() {
                this.sidebar.classList.toggle('sidebar-hidden');
                this.sidebar.classList.toggle('sidebar-visible');
                this.mainContent.classList.toggle('content-shifted');
                this.mainContent.classList.toggle('content-full');
                this.sidebarToggle.classList.toggle('toggle-moved');
                this.sidebarToggle.classList.toggle('toggle-default');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            new Sidebar();
        });
    </script>
</body>
</html>
