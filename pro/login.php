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
    <title>Login - Trae AI</title>
    <link href="/src/output.css" rel="stylesheet">
    <link href="/src/trae-theme.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Check if user is already logged in via sessionStorage (client-side check)
        window.addEventListener('DOMContentLoaded', function() {
            // Removed client-side redirect to prevent race condition
            // Server-side validation in PHP handles redirects exclusively
        });
    </script>
</head>
<body class="bg-[#1E1E2E] text-[#F0F0F0]" x-data="{ isMenuOpen: false }">
    <!-- Navigation -->
    <nav class="trae-navbar fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="index.php" class="text-2xl font-bold text-gradient">Trae AI</a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-auto sm:flex sm:items-center sm:space-x-8">
                    <a href="index.php" class="border-transparent text-[#A0A0B0] hover:text-[#D76D77] transition-colors duration-300 inline-flex items-center px-3 py-2 text-sm font-medium">Home</a>
                    <a href="about.php" class="border-transparent text-[#A0A0B0] hover:text-[#D76D77] transition-colors duration-300 inline-flex items-center px-3 py-2 text-sm font-medium">About</a>
                    <a href="report.php" class="border-transparent text-[#A0A0B0] hover:text-[#D76D77] transition-colors duration-300 inline-flex items-center px-3 py-2 text-sm font-medium">Report</a>
                    <a href="login.php" class="text-white font-medium bg-gradient-to-r from-[#4A1E73] to-[#D76D77] rounded-lg px-4 py-2 text-sm transition-transform duration-300 hover:scale-105">Login</a>
                </div>

                <!-- Mobile menu button -->
                <div class="sm:hidden flex items-center">
                    <button @click="isMenuOpen = !isMenuOpen" class="text-[#A0A0B0] hover:text-[#D76D77] transition-colors duration-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="isMenuOpen" class="sm:hidden bg-[#2E2E4E] border-t border-[rgba(255,255,255,0.1)]">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.php" class="block px-3 py-2 text-[#A0A0B0] hover:text-[#D76D77] transition-colors duration-300">Home</a>
                <a href="about.php" class="block px-3 py-2 text-[#A0A0B0] hover:text-[#D76D77] transition-colors duration-300">About</a>
                <a href="report.php" class="block px-3 py-2 text-[#A0A0B0] hover:text-[#D76D77] transition-colors duration-300">Report</a>
                <a href="login.php" class="block px-3 py-2 text-[#D76D77] font-semibold">Login</a>
            </div>
        </div>
    </nav>

    <!-- Login Form Section -->
    <div class="min-h-screen flex items-center justify-center pt-16 bg-[#1E1E2E] bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-[#2E2E4E] via-[#1E1E2E] to-[#1E1E2E]">
        <div class="max-w-md w-full mx-4">
            <div class="trae-card p-8 space-y-6">
                <div class="text-center space-y-2">
                    <h2 class="text-3xl font-bold text-gradient">Welcome Back</h2>
                    <p class="text-[#A0A0B0]">Sign in to your Trae AI account</p>
                </div>

                <!-- Error Alert -->
                <div id="server-error" class="hidden bg-[rgba(215,109,119,0.1)] border border-[#D76D77] text-[#D76D77] px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline"></span>
                </div>

                <form id="loginForm" class="mt-8 space-y-6">
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-[#A0A0B0]">Email address</label>
                        <input id="email" name="email" type="email" required 
                               class="block w-full px-4 py-3 bg-[rgba(30,30,46,0.6)] border border-[rgba(74,30,115,0.3)] rounded-lg shadow-sm focus:outline-none focus:border-[#D76D77] focus:ring-2 focus:ring-[rgba(215,109,119,0.3)] transition-all duration-300">
                    </div>
                
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-[#A0A0B0]">Password</label>
                        <input id="password" name="password" type="password" required
                               class="block w-full px-4 py-3 bg-[rgba(30,30,46,0.6)] border border-[rgba(74,30,115,0.3)] rounded-lg shadow-sm focus:outline-none focus:border-[#D76D77] focus:ring-2 focus:ring-[rgba(215,109,119,0.3)] transition-all duration-300">
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                   class="h-4 w-4 text-[#D76D77] focus:ring-[#4A1E73] border-[rgba(74,30,115,0.5)] rounded bg-[rgba(30,30,46,0.6)]">
                            <label for="remember-me" class="ml-2 block text-sm text-[#A0A0B0]">Remember me</label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-[#D76D77] hover:text-[#FFAF7B] transition-colors duration-300">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <div id="error-message" class="hidden text-[#D76D77] text-sm"></div>

                    <div>
                        <button type="submit"
                                class="btn-gradient w-full flex justify-center py-3 px-4 rounded-lg shadow-lg text-sm font-medium text-white transition-all duration-300 hover:shadow-xl hover:scale-[1.02]">
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <p class="text-sm text-[#A0A0B0]">
                        Don't have an account?
                        <a href="signup.html" class="font-medium text-[#D76D77] hover:text-[#FFAF7B] transition-colors duration-300">Sign up</a>
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

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<span class="inline-block animate-pulse">Signing in...</span>';
            submitBtn.disabled = true;
            
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
                    // Show error message in the error div instead of an alert
                    const errorDiv = document.getElementById('error-message');
                    errorDiv.textContent = data.message || 'Invalid email or password';
                    errorDiv.classList.remove('hidden');
                    
                    // Reset button
                    submitBtn.innerHTML = 'Sign in';
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const errorDiv = document.getElementById('error-message');
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.classList.remove('hidden');
                
                // Reset button
                submitBtn.innerHTML = 'Sign in';
                submitBtn.disabled = false;
            });
        });
    </script>
</body>
</html>