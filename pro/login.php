<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
session_start();

// Immediate session validation before any output
if(isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit();
}

// Prevent session fixation
session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SheShield</title>
    <link href="/src/output.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Check if user is already logged in via sessionStorage (client-side check)
        window.addEventListener('DOMContentLoaded', function() {
            // Removed client-side redirect to prevent race condition
            // Server-side validation in PHP handles redirects exclusively
        });
    </script>
</head>
<body class="bg-gray-50" x-data="{ isMenuOpen: false }">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="index.php" class="text-2xl font-bold text-pink-600">SheShield</a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-auto sm:flex sm:items-center sm:space-x-8">
                    <a href="index.php" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                    <a href="about.php" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">About</a>
                    <a href="report.php" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Report</a>
                    <a href="login.php" class="border-pink-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Login</a>
                </div>

                <!-- Mobile menu button -->
                <div class="sm:hidden flex items-center">
                    <button @click="isMenuOpen = !isMenuOpen" class="text-gray-700 hover:text-pink-600 transition-colors duration-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="isMenuOpen" class="sm:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.php" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors">Home</a>
                <a href="about.php" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors">About</a>
                <a href="report.php" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors">Report</a>
                <a href="login.php" class="block px-3 py-2 text-pink-600 font-semibold">Login</a>
            </div>
        </div>
    </nav>

    <!-- Login Form Section -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-100 via-white to-purple-100">
        <div class="max-w-md w-full mx-4">
            <div class="bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg rounded-2xl shadow-xl p-8 space-y-6">
                <div class="text-center space-y-2">
                    <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                    <p class="text-gray-600">Sign in to your SheShield account</p>
                </div>

                <!-- Error Alert -->
                <div id="server-error" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"></span>
                </div>

                <form id="loginForm" class="mt-8 space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input id="email" name="email" type="email" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                    </div>
                
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                   class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-pink-600 hover:text-pink-500">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <div id="error-message" class="hidden text-red-600 text-sm"></div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="signup.html" class="font-medium text-pink-600 hover:text-pink-500">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };

            fetch('../api/auth/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Server-side session already established
                    window.location.href = data.redirect || '../dashboard.php';
                } else {
                    alert(data.message || 'Invalid email or password');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    </script>
</body>
</html>