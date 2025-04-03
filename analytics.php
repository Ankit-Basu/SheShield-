<?php
session_start();
require_once 'database/mysqli_db.php';

// Initialize database connection
$conn = get_mysqli_connection();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>

    <style>
        .sidebar-hidden { transform: translateX(-100%); }
        .sidebar-visible { transform: translateX(0); }
        .toggle-moved { transform: translateX(16rem) translateY(-50%); }
        .toggle-default { transform: translateX(0) translateY(-50%); }
        .content-shifted { margin-left: 16rem; }
        .content-full { margin-left: 0; }
    </style>
</head>
<body class="bg-[#F9E9F0] text-[#333333]">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed w-64 bg-[#D12E79] text-white p-5 flex flex-col h-full z-40 transition-transform duration-300 ease-in-out sidebar-hidden md:sidebar-visible">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-shield-halved text-3xl"></i>
                    <span class="text-lg font-bold"><?php 
                    // Get user's name from session
                    echo isset($_SESSION['first_name']) ? 'Welcome ' . htmlspecialchars($_SESSION['first_name']) : 'User Name'; 
                    ?></span>
                </div>
            </div>
            <nav>
                <ul>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='dashboard.php'">
                        <i class="fa-solid fa-house"></i> <span>Home</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='report.php'">
                        <i class="fa-solid fa-file"></i> <span>Reports</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='analytics.php'">
                        <i class="fa-solid fa-chart-bar"></i> <span>Analytics</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='map.php'">
                        <i class="fa-solid fa-map"></i> <span>Map</span>
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
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="window.location.href='settings.php'">
                        <i class="fa-solid fa-gear"></i> <span>Settings</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="window.location.href='auth/logout.php'">
                        <i class="fa-solid fa-sign-out-alt"></i> <span>Logout</span>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="fixed left-0 top-1/2 bg-[#D12E79] text-white p-2 rounded-r z-50 transition-transform duration-300 ease-in-out toggle-default md:toggle-moved">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-10 transition-all duration-300 ease-in-out content-full md:content-shifted">
            <div id="content">
                <h1 class="text-3xl font-bold">Analytics Dashboard</h1>
                
                <!-- Case Tracking Section -->
<div class="mt-8 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Case Tracking</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Case ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Complaint Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Reported</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Personnel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                // Query to get cases based on user permissions
                $user_id = $_SESSION['user_id'];
                $user_role = $_SESSION['role'] ?? 'user';
                
                // Build query based on user role
                $query = "SELECT 
                            i.id AS case_id, 
                            i.incident_type AS complaint_type, 
                            i.date_time AS date_reported, 
                            CONCAT(u.first_name, ' ', u.last_name) AS assigned_personnel, 
                            i.status
                          FROM incidents i
                          LEFT JOIN users u ON i.user_id = u.id
                          WHERE 1=1";
                
                // Filter based on user role
                if ($user_role != 'admin') {
                    $query .= " AND i.user_id = $user_id";
                }
                
                $query .= " ORDER BY i.date_time DESC";
                
                $result = $conn->query($query);
                $rows = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $rows[] = $row;
                    }
                }
                
                if (count($rows) > 0) {
                    foreach($rows as $row) {
                        echo '<tr>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['case_id']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['complaint_type']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['date_reported']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['assigned_personnel'] ?? 'Unassigned') . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['status']) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No cases found</td></tr>';
                }
                $conn = null;
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Analytics Charts Section -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Case Status Distribution -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Case Status Distribution</h2>
        <canvas id="statusChart"></canvas>
    </div>

    <!-- Incident Types Distribution -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Incident Types Distribution</h2>
        <canvas id="incidentTypeChart"></canvas>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Fetch data for charts
    <?php
    // Reconnect to database since it was closed earlier
    $conn = get_mysqli_connection();
    
    // Query for case status distribution
    $statusQuery = "SELECT status, COUNT(*) as count FROM incidents ";
    if ($user_role != 'admin') {
        $statusQuery .= "WHERE user_id = $user_id ";
    }
    $statusQuery .= "GROUP BY status";
    $statusResult = $conn->query($statusQuery);

    $statusLabels = [];
    $statusData = [];
    if ($statusResult) {
        while($row = $statusResult->fetch_assoc()) {
            $statusLabels[] = $row['status'];
            $statusData[] = $row['count'];
        }
    }

    // Query for incident types distribution
    $typeQuery = "SELECT incident_type, COUNT(*) as count FROM incidents ";
    if ($user_role != 'admin') {
        $typeQuery .= "WHERE user_id = $user_id ";
    }
    $typeQuery .= "GROUP BY incident_type";
    $typeResult = $conn->query($typeQuery);

    $typeLabels = [];
    $typeData = [];
    if ($typeResult) {
        while($row = $typeResult->fetch_assoc()) {
            $typeLabels[] = $row['incident_type'];
            $typeData[] = $row['count'];
        }
    }
    $conn = null;
    ?>

    // Case Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($statusLabels); ?>,
            datasets: [{
                data: <?php echo json_encode($statusData); ?>,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Incident Types Chart
    const typeCtx = document.getElementById('incidentTypeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($typeLabels); ?>,
            datasets: [{
                label: 'Number of Cases',
                data: <?php echo json_encode($typeData); ?>,
                backgroundColor: '#D12E79',
                borderColor: '#AB1E5C',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
                
            </div>
        </main>
    </div>

    <!-- Sidebar Script -->
    <script src="sidebar.js"></script>

</body>
</html>