<?php
session_start();
require_once '../utils/session.php';
require_once '../config/database.php';
require_once '../models/Incident.php';

// Check if user is logged in and is admin
if (!Session::isLoggedIn() || !Session::get('is_admin')) {
    header('Location: ../login.html');
    exit();
}

// Check if incident ID is provided
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

// Initialize database connection
$database = new Database();
$db = $database->getConnection();
$incident = new Incident($db);

// Get incident details
$incident_id = $_GET['id'];
$incident->getById($incident_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Incident - SheShield Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="/images/logo.png">
</head>
<body class="bg-gray-100">
    <!-- Admin Navigation -->
    <nav class="bg-gray-900 text-white px-6 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold">SheShield Admin</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="index.php" class="hover:text-gray-300">Dashboard</a>
                <a href="../api/auth/logout.php" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Incident Details -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-2xl font-semibold">Incident Report #<?php echo htmlspecialchars($incident->id); ?></h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    <?php 
                    switch($incident->status) {
                        case 'pending':
                            echo 'bg-yellow-100 text-yellow-800';
                            break;
                        case 'in_progress':
                            echo 'bg-blue-100 text-blue-800';
                            break;
                        case 'resolved':
                            echo 'bg-green-100 text-green-800';
                            break;
                        case 'closed':
                            echo 'bg-gray-100 text-gray-800';
                            break;
                    }
                    ?>">
                    <?php echo ucfirst(htmlspecialchars($incident->status)); ?>
                </span>
            </div>

            <div class="p-6">
                <!-- Incident Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Incident Details</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Type of Incident</label>
                                <p class="mt-1 text-gray-900"><?php echo htmlspecialchars($incident->type); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Location</label>
                                <p class="mt-1 text-gray-900"><?php echo htmlspecialchars($incident->location); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Incident Date</label>
                                <p class="mt-1 text-gray-900"><?php echo htmlspecialchars($incident->incident_date); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Report Date</label>
                                <p class="mt-1 text-gray-900"><?php echo htmlspecialchars($incident->created_at); ?></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Reporter Information</h3>
                        <div class="space-y-3">
                            <?php if (!$incident->is_anonymous): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Reporter Name</label>
                                <p class="mt-1 text-gray-900">
                                    <?php 
                                    require_once '../models/User.php';
                                    $user = new User($db);
                                    $user->getById($incident->user_id);
                                    echo htmlspecialchars($user->first_name . ' ' . $user->last_name);
                                    ?>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Contact Information</label>
                                <p class="mt-1 text-gray-900">
                                    Email: <?php echo htmlspecialchars($user->email); ?><br>
                                    Phone: <?php echo htmlspecialchars($user->phone); ?>
                                </p>
                            </div>
                            <?php else: ?>
                            <div>
                                <p class="text-gray-900">This report was submitted anonymously</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Incident Description</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-900 whitespace-pre-line"><?php echo htmlspecialchars($incident->description); ?></p>
                    </div>
                </div>

                <!-- Evidence Files -->
                <?php if ($incident->evidence_files): ?>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Evidence Files</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php 
                        $files = explode(',', $incident->evidence_files);
                        foreach ($files as $file):
                            $file = trim($file);
                            $ext = pathinfo($file, PATHINFO_EXTENSION);
                            $is_image = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']);
                        ?>
                        <div class="border rounded-lg p-4">
                            <?php if ($is_image): ?>
                            <img src="../uploads/evidence/<?php echo htmlspecialchars($file); ?>" 
                                 alt="Evidence" class="w-full h-48 object-cover rounded">
                            <?php else: ?>
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span class="ml-2 text-sm text-gray-600"><?php echo htmlspecialchars($file); ?></span>
                            </div>
                            <?php endif; ?>
                            <a href="../uploads/evidence/<?php echo htmlspecialchars($file); ?>" 
                               class="mt-2 inline-block text-indigo-600 hover:text-indigo-900" 
                               target="_blank">View File</a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-8">
                    <button onclick="updateStatus(<?php echo $incident->id; ?>)" 
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Update Status
                    </button>
                    <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateStatus(incidentId) {
            const newStatus = prompt('Enter new status (pending, in_progress, resolved, closed):');
            if (newStatus) {
                fetch('../api/incidents/update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: incidentId,
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert('Error updating status: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating status');
                });
            }
        }
    </script>
</body>
</html>
