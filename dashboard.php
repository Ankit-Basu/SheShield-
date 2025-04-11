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
        body {
            background: linear-gradient(135deg, #1E1E2E 0%, #2E2E4E 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Glassmorphic Effects */
        .glass-effect {
            background: rgba(46, 46, 78, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(74, 30, 115, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        
        .trae-sidebar {
            background: rgba(46, 46, 78, 0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-right: 1px solid rgba(74, 30, 115, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        
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
        
        /* Original sidebar behavior */
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
        }
        .toggle-default { 
            transform: translateX(0) translateY(-50%);
        }
        .content-shifted { 
            margin-left: 16rem;
            transition: all 0.3s ease-in-out;
        }
        .content-full { 
            margin-left: 0;
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-[#1E1E2E] text-[#F0F0F0]">
    <div class="flex h-screen overflow-hidden relative z-0">
        <!-- Background gradient shapes -->
        <div class="absolute -top-[300px] -right-[300px] w-[600px] h-[600px] bg-gradient-to-r from-[rgba(74,30,115,0.3)] to-[rgba(215,109,119,0.3)] rounded-full blur-3xl -z-10 animate-pulse-slow"></div>
        <div class="absolute -bottom-[200px] -left-[200px] w-[500px] h-[500px] bg-gradient-to-r from-[rgba(215,109,119,0.2)] to-[rgba(74,30,115,0.2)] rounded-full blur-3xl -z-10 animate-pulse-slow opacity-70"></div>
        <!-- Sidebar -->
        <aside id="sidebar" class="trae-sidebar fixed w-64 text-white p-5 flex flex-col h-full z-40 transition-transform duration-300 ease-in-out sidebar-hidden md:sidebar-visible">

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
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 cursor-pointer" onclick="window.location.href='analytics.php'">
                        <i class="fa-solid fa-chart-bar"></i> <span>Analytics</span>
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
                    <li class="trae-sidebar-item p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="window.location.href='auth/logout.php'">
                        <i class="fa-solid fa-sign-out-alt"></i> <span>Logout</span>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="fixed left-0 top-1/2 glass-effect bg-gradient-to-r from-[rgba(74,30,115,0.5)] to-[rgba(215,109,119,0.5)] text-white p-3 rounded-r z-50 transition-transform duration-300 ease-in-out toggle-default md:toggle-moved hover:shadow-lg">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-10 transition-all duration-300 ease-in-out content-full md:content-shifted">
            <div id="content">
                <h1 class="text-3xl font-bold text-gradient">Dashboard Overview</h1>
                
                <!-- Dashboard Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8 animate-fade-in">
                    <!-- Analytics Card -->
                    <a href="analytics.php" class="block">
                        <div class="trae-card rounded-xl overflow-hidden group">
                            <div class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] h-2 group-hover:h-3 transition-all duration-300"></div>
                            <div class="p-6 relative overflow-hidden z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-xl font-semibold text-white">Analytics Dashboard</h2>
                                    <div class="glass-effect p-3 rounded-full transform transition-all duration-300 group-hover:scale-110">
                                        <i class="fa-solid fa-chart-bar text-[#D76D77] text-xl"></i>
                                    </div>
                                </div>
                                <p class="text-[#A0A0B0] mt-4">View comprehensive analytics, case statistics, and data visualizations.</p>
                                <div class="mt-6 flex items-center text-[#D76D77] relative z-10 transition-all duration-300 group-hover:translate-x-2">
                                    <span>Explore Analytics</span>
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Reports Card -->
                    <a href="report.php" class="block">
                        <div class="trae-card rounded-xl overflow-hidden group">
                            <div class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] h-2 group-hover:h-3 transition-all duration-300"></div>
                            <div class="p-6 relative overflow-hidden z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-xl font-semibold text-white">Reports</h2>
                                    <div class="glass-effect p-3 rounded-full transform transition-all duration-300 group-hover:scale-110">
                                        <i class="fa-solid fa-file text-[#D76D77] text-xl"></i>
                                    </div>
                                </div>
                                <p class="text-[#A0A0B0] mt-4">Access and manage incident reports and case documentation.</p>
                                <div class="mt-6 flex items-center text-[#D76D77] relative z-10 transition-all duration-300 group-hover:translate-x-2">
                                    <span>View Reports</span>
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Map Card -->
                    <a href="map.php" class="block">
                        <div class="trae-card rounded-xl overflow-hidden group">
                            <div class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] h-2 group-hover:h-3 transition-all duration-300"></div>
                            <div class="p-6 relative overflow-hidden z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-xl font-semibold text-white">Safety Map</h2>
                                    <div class="glass-effect p-3 rounded-full transform transition-all duration-300 group-hover:scale-110">
                                        <i class="fa-solid fa-map text-[#D76D77] text-xl"></i>
                                    </div>
                                </div>
                                <p class="text-[#A0A0B0] mt-4">View incident locations and safety information on an interactive map.</p>
                                <div class="mt-6 flex items-center text-[#D76D77] relative z-10 transition-all duration-300 group-hover:translate-x-2">
                                    <span>Open Map</span>
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebarToggle');
            const mainContent = document.getElementById('mainContent');

            function setInitialState() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('sidebar-hidden');
                    sidebar.classList.remove('sidebar-visible');
                    toggleButton.classList.add('toggle-default');
                    toggleButton.classList.remove('toggle-moved');
                    mainContent.classList.add('content-full');
                    mainContent.classList.remove('content-shifted');
                } else {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.add('sidebar-visible');
                    toggleButton.classList.remove('toggle-default');
                    toggleButton.classList.add('toggle-moved');
                    mainContent.classList.remove('content-full');
                    mainContent.classList.add('content-shifted');
                }
            }
            
            setInitialState();
            window.addEventListener('resize', setInitialState);

            toggleButton.addEventListener('click', function() {
                if (sidebar.classList.contains('sidebar-hidden')) {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.add('sidebar-visible');
                    toggleButton.classList.remove('toggle-default');
                    toggleButton.classList.add('toggle-moved');
                    mainContent.classList.remove('content-full');
                    mainContent.classList.add('content-shifted');
                } else {
                    sidebar.classList.add('sidebar-hidden');
                    sidebar.classList.remove('sidebar-visible');
                    toggleButton.classList.add('toggle-default');
                    toggleButton.classList.remove('toggle-moved');
                    mainContent.classList.add('content-full');
                    mainContent.classList.remove('content-shifted');
                }
            });
        });
    </script>
</body>
</html>
