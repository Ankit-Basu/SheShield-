<?php
session_start();
require_once 'mysql_db.php';

// Get the latest active emergency response with alert status
$sql = "SELECT er.*, ea.status as alert_status 
        FROM emergency_responses er 
        LEFT JOIN emergency_alerts ea ON er.alert_id = ea.id 
        WHERE er.case_resolved = 0 
        ORDER BY er.id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$response = mysqli_fetch_assoc($result);

// Set default values if no response exists
if (!$response) {
    // Clear any existing progress
    echo '<div class="bg-white p-8 rounded-2xl shadow-xl opacity-75 col-span-1 md:col-span-2 text-center">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-circle text-4xl text-gray-400 mr-3"></i>
                <h2 class="text-2xl font-bold text-gray-500">No Active Emergency</h2>
            </div>
            <p class="text-gray-500">There are currently no active emergency cases.</p>
         </div>';
    exit();
} else if ($response['case_resolved'] == 1) {
    // Show case resolved message
    echo '<div class="bg-white p-8 rounded-2xl shadow-xl col-span-1 md:col-span-2 text-center">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-check-circle text-4xl text-green-500 mr-3"></i>
                <h2 class="text-2xl font-bold text-gray-700">Case Successfully Resolved</h2>
            </div>
            <p class="text-gray-600">No active emergency cases at the moment.</p>
        </div>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Women Safety</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <style>
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        .content-full {
            margin-left: 0 !important;
        }
        .toggle-default {
            transform: translateX(0) translateY(-50%) !important;
        }
        .progress-bar {
            transition: width 0.3s ease-in-out;
        }
        .case-resolved {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed w-64 bg-[#D12E79] text-white p-5 flex flex-col h-full z-40">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-shield-halved text-3xl"></i>
                    <span class="text-lg font-bold">Women Safety</span>
                </div>
            </div>
            <nav class="sidebar-content">
                <ul>
                    <li onclick="window.location.href='dashboard.php'" class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <i class="fa-solid fa-house"></i> <span>Home</span>
                    </li>
                    <li onclick="window.location.href='report.php'" class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <i class="fa-solid fa-file"></i> <span>Reports</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 bg-[#AB1E5C]">
                        <i class="fa-solid fa-chart-bar"></i> <span>Analytics</span>
                    </li>
                    <li onclick="window.location.href='map.php'" class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <i class="fa-solid fa-map"></i> <span>Map</span>
                    </li>
                                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="window.location.href='settings.php'">
                        <i class="fa-solid fa-gear"></i> <span>Settings</span>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="fixed left-0 top-1/2 bg-[#D12E79] text-white p-2 rounded-r z-50 transition-transform duration-300 ease-in-out" style="transform: translateX(16rem) translateY(-50%)">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-10 ml-64 transition-all duration-300">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Emergency Response Progress Tile -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 <?php echo (!$response || $response['id'] == 0) ? 'case-resolved' : ''; ?>">
                    <h2 class="text-xl font-bold text-[#D12E79] mb-4 flex items-center gap-2">
                        <i class="fas fa-shield-alt text-lg"></i>
                        <span>Emergency Response Progress</span>
                    </h2>
                    <div class="relative">
                        <!-- Vertical Timeline Line -->
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                        
                        <!-- Progress Steps -->
                        <div class="space-y-4 relative">
                            <!-- Alert Sent Step -->
                            <div class="flex items-center group" data-status="notified">
                                <div class="w-12 h-12 <?php echo $response['notified_time'] ? 'bg-[#D12E79]' : 'bg-gray-300'; ?> rounded-full flex items-center justify-center text-white shadow-lg transform transition-transform group-hover:scale-110 z-10">
                                    <i class="fas fa-bell text-xl"></i>
                                </div>
                                <div class="ml-8 flex-1 bg-gray-50 rounded-xl p-6 transform transition-all duration-300 hover:translate-x-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold <?php echo $response['notified_time'] ? 'text-[#D12E79]' : 'text-gray-500'; ?> text-lg">Alert Sent</p>
                                            <p class="text-sm text-gray-500 mt-1"><?php echo $response['notified_time'] ? date('h:i A', strtotime($response['notified_time'])) : '--:-- --'; ?></p>
                                        </div>
                                        <button onclick="updateStatus('notified')" class="px-6 py-3 rounded-lg <?php echo $response['notified_time'] ? 'bg-[#D12E79]' : 'bg-gray-200 hover:bg-[#D12E79]'; ?> text-white transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#D12E79] focus:ring-opacity-50">
                                            <i class="fas fa-check mr-2"></i>Confirm
                                        </button>
                                    </div>
                                    <div class="mt-3 h-1 <?php echo $response['notified_time'] ? 'bg-[#D12E79]' : 'bg-gray-200'; ?> rounded-full progress-bar"></div>
                                </div>
                            </div>

                            <!-- Team Dispatched Step -->
                            <div class="flex items-center group" data-status="dispatched">
                                <div class="w-10 h-10 <?php echo $response['dispatched_time'] ? 'bg-[#D12E79]' : 'bg-gray-300'; ?> rounded-full flex items-center justify-center text-white shadow-lg transform transition-transform group-hover:scale-110 z-10">
                                    <i class="fas fa-running text-lg"></i>
                                </div>
                                <div class="ml-6 flex-1 bg-gray-50 rounded-xl p-4 transform transition-all duration-300 hover:translate-x-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold <?php echo $response['dispatched_time'] ? 'text-[#D12E79]' : 'text-gray-500'; ?> text-lg">Help on the way</p>
                                            <p class="text-sm text-gray-500 mt-1"><?php echo $response['dispatched_time'] ? date('h:i A', strtotime($response['dispatched_time'])) : '--:-- --'; ?></p>
                                        </div>
                                        <button onclick="updateStatus('dispatched')" 
                                                class="px-4 py-2 rounded-lg <?php echo $response['dispatched_time'] ? 'bg-[#D12E79]' : 'bg-gray-200 hover:bg-[#D12E79]'; ?> text-white transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#D12E79] focus:ring-opacity-50"
                                                <?php echo !$response['notified_time'] ? 'disabled' : ''; ?>>
                                            <i class="fas fa-check mr-2"></i>Confirm
                                        </button>
                                    </div>
                                    <div class="mt-3 h-1 <?php echo $response['dispatched_time'] ? 'bg-[#D12E79]' : 'bg-gray-200'; ?> rounded-full progress-bar"></div>
                                </div>
                            </div>

                            <!-- Team Arrived Step -->
                            <div class="flex items-center group" data-status="arrived">
                                <div class="w-10 h-10 <?php echo $response['arrived_time'] ? 'bg-[#D12E79]' : 'bg-gray-300'; ?> rounded-full flex items-center justify-center text-white shadow-lg transform transition-transform group-hover:scale-110 z-10">
                                    <i class="fas fa-location-dot text-lg"></i>
                                </div>
                                <div class="ml-6 flex-1 bg-gray-50 rounded-xl p-4 transform transition-all duration-300 hover:translate-x-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold <?php echo $response['arrived_time'] ? 'text-[#D12E79]' : 'text-gray-500'; ?> text-lg">Have responders arrived?</p>
                                            <p class="text-sm text-gray-500 mt-1"><?php echo $response['arrived_time'] ? date('h:i A', strtotime($response['arrived_time'])) : '--:-- --'; ?></p>
                                        </div>
                                        <button onclick="updateStatus('arrived')" 
                                                class="px-4 py-2 rounded-lg <?php echo $response['arrived_time'] ? 'bg-[#D12E79]' : 'bg-gray-200 hover:bg-[#D12E79]'; ?> text-white transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#D12E79] focus:ring-opacity-50"
                                                <?php echo !$response['dispatched_time'] ? 'disabled' : ''; ?>>
                                            <i class="fas fa-check mr-2"></i>Confirm
                                        </button>
                                    </div>
                                    <div class="mt-3 h-1 <?php echo $response['arrived_time'] ? 'bg-[#D12E79]' : 'bg-gray-200'; ?> rounded-full progress-bar"></div>
                                </div>
                            </div>

                            <!-- Resolved Step -->
                            <div class="flex items-center group" data-status="resolved">
                                <div class="w-10 h-10 <?php echo $response['resolved_time'] ? 'bg-[#D12E79]' : 'bg-gray-300'; ?> rounded-full flex items-center justify-center text-white shadow-lg transform transition-transform group-hover:scale-110 z-10">
                                    <i class="fas fa-check-double text-lg"></i>
                                </div>
                                <div class="ml-6 flex-1 bg-gray-50 rounded-xl p-4 transform transition-all duration-300 hover:translate-x-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold <?php echo $response['resolved_time'] ? 'text-[#D12E79]' : 'text-gray-500'; ?> text-lg">Issue resolved?</p>
                                            <p class="text-sm text-gray-500 mt-1"><?php echo $response['resolved_time'] ? date('h:i A', strtotime($response['resolved_time'])) : '--:-- --'; ?></p>
                                        </div>
                                        <button onclick="updateStatus('resolved')" 
                                                class="px-4 py-2 rounded-lg <?php echo $response['resolved_time'] ? 'bg-[#D12E79]' : 'bg-gray-200 hover:bg-[#D12E79]'; ?> text-white transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#D12E79] focus:ring-opacity-50"
                                                <?php echo !$response['arrived_time'] ? 'disabled' : ''; ?>>
                                            <i class="fas fa-check mr-2"></i>Confirm
                                        </button>
                                    </div>
                                    <div class="mt-3 h-1 <?php echo $response['resolved_time'] ? 'bg-[#D12E79]' : 'bg-gray-200'; ?> rounded-full progress-bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($response['resolved_time'] && !$response['case_resolved']): ?>
                    <div class="mt-8 text-center">
                        <button onclick="markCaseResolved(<?php echo $response['id']; ?>)" 
                                class="px-6 py-3 bg-[#D12E79] text-white rounded-xl hover:bg-[#AB1E5C] transition-colors duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#D12E79] focus:ring-opacity-50">
                            <i class="fas fa-flag-checkered mr-2"></i>Mark Case as Resolved
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Function to show case resolved button
        function showCaseResolvedButton(responseId) {
            const resolvedStep = document.querySelector('[data-status="resolved"]');
            const buttonContainer = document.createElement('div');
            buttonContainer.className = 'mt-6 text-center';
            buttonContainer.innerHTML = `
                <button onclick="markCaseResolved(${responseId})" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Mark Case as Resolved
                </button>
            `;
            resolvedStep.parentNode.insertBefore(buttonContainer, resolvedStep.nextSibling);
        }

        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggle = document.getElementById('sidebarToggle');
            
            sidebar.classList.toggle('sidebar-hidden');
            mainContent.classList.toggle('content-full');
            toggle.classList.toggle('toggle-default');
        });

        function updateStatus(status) {
            if (!confirm(`Confirm updating status to: ${status}?`)) return;

            const responseId = <?php echo $response['id']; ?>;
            if (!responseId) {
                alert('No active emergency response found');
                return;
            }

            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    status: status,
                    response_id: responseId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI elements
                    const statusElement = document.querySelector(`[data-status="${status}"]`);
                    const iconCircle = statusElement.querySelector('.w-10');
                    const progressBar = statusElement.querySelector('.h-1');
                    const statusText = statusElement.querySelector('.font-semibold');
                    const timeText = statusElement.querySelector('.text-sm');
                    const button = statusElement.querySelector('button');
                    
                    // Update time display
                    if (timeText) {
                        timeText.textContent = new Date().toLocaleTimeString('en-US', { 
                            hour: 'numeric', 
                            minute: '2-digit', 
                            hour12: true 
                        });
                    }

                    // Update visual elements
                    iconCircle.classList.remove('bg-gray-300');
                    iconCircle.classList.add('bg-[#D12E79]');
                    if (progressBar) {
                        progressBar.classList.remove('bg-gray-200');
                        progressBar.classList.add('bg-[#D12E79]');
                    }
                    if (statusText) {
                        statusText.classList.remove('text-gray-500');
                        statusText.classList.add('text-[#D12E79]');
                    }
                    if (button) {
                        button.classList.remove('bg-gray-200');
                        button.classList.add('bg-[#D12E79]');
                    }

                    // Enable next step if exists
                    const nextStatus = {
                        'notified': 'dispatched',
                        'dispatched': 'arrived',
                        'arrived': 'resolved'
                    };
                    
                    if (nextStatus[status]) {
                        const nextButton = document.querySelector(`[data-status="${nextStatus[status]}"] button`);
                        if (nextButton) {
                            nextButton.removeAttribute('disabled');
                        }
                    }

                    if (status === 'resolved') {
                        showCaseResolvedButton(responseId);
                    }
                } else {
                    console.error('Failed to update status:', data.message || 'Unknown error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function markCaseResolved(id) {
            if (!confirm('Are you sure you want to mark this case as completely resolved? This will clear the progress tracking.')) return;

            fetch('mark_case_resolved.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    response_id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Instead of reloading, update the UI to show case resolved state
                    const progressContainer = document.querySelector('.grid');
                    const noActiveMessage = document.createElement('div');
                    noActiveMessage.className = 'bg-white p-8 rounded-2xl shadow-xl col-span-1 md:col-span-2 text-center';
                    noActiveMessage.innerHTML = `
                        <div class="flex items-center justify-center mb-4">
                            <i class="fas fa-check-circle text-4xl text-green-500 mr-3"></i>
                            <h2 class="text-2xl font-bold text-gray-700">Case Successfully Resolved</h2>
                        </div>
                        <p class="text-gray-600">No active emergency cases at the moment.</p>
                    `;
                    progressContainer.innerHTML = '';
                    progressContainer.appendChild(noActiveMessage);
                } else {
                    alert('Failed to mark case as resolved: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking case as resolved');
            });
        }
    </script>
</body>
</html>