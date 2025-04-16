<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - SheShield</title>
    <!-- <link href="/src/output.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-[Inter] bg-[#1E1E2E]" x-data="{ isMenuOpen: false }">
    <!-- Navigation -->
    <nav class="fixed w-full top-0 bg-[#1E1E2E] shadow-lg z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" class="flex-shrink-0">
                    <circle cx="20" cy="20" r="18" stroke="#D76D77" stroke-width="4"/>
                    <path d="M20 10L24 16H16L20 10Z" fill="#D76D77"/>
                    <rect x="18" y="16" width="4" height="14" rx="2" fill="#D76D77"/>
                </svg>
                <span class="text-2xl font-bold text-[#D76D77]">SheShield</span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="landing.html" class="text-white hover:text-[#D76D77] transition-colors duration-300">Home</a>
                <a href="landing.html#about" class="text-white hover:text-[#D76D77] transition-colors duration-300">About Us</a>
                <a href="landing.html#features" class="text-white hover:text-[#D76D77] transition-colors duration-300">Safety Services</a>
                <a href="landing.html#how-it-works" class="text-white hover:text-[#D76D77] transition-colors duration-300">How It Works</a>
                <a href="landing.html#contact" class="text-white hover:text-[#D76D77] transition-colors duration-300">Emergency</a>
            </div>
            <div class="flex items-center space-x-4">
                <button class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:from-[#5A2E83] hover:to-[#E77D87] text-white px-8 py-3 rounded-full transition-all duration-300 hover:shadow-lg transform hover:scale-[1.02] flex items-center space-x-2" onclick="window.location.href='login.html'">Log In</button>
                <button class="bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:from-[#5A2E83] hover:to-[#E77D87] text-white px-8 py-3 rounded-full transition-all duration-300 hover:shadow-lg transform hover:scale-[1.02] flex items-center space-x-2" onclick="window.location.href='report.html'">Report Now</button>
            </div>
        </div>
    </nav>

    <!-- Sign Up Form -->
    <div class="min-h-screen flex items-center mt-10 justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-[#2E2E4E] p-8 rounded-lg shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-white">Join SheShield</h2>
                <p class="mt-2 text-center text-sm text-[#D76D77]">
                    Already have an account?
                    <a href="login.html" class="font-medium text-blue-600 hover:text-white transition-colors duration-300">
                        Sign in here
                    </a>
                </p>
            </div>
            <form id="signupForm" class="mt-8 space-y-6">
                <!-- Personal Information -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-[#D76D77] mb-1">First Name</label>
                            <input id="first_name" name="first_name" type="text" required
                                class="appearance-none bg-[#1E1E2E] relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-white rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm"
                                placeholder="Enter your first name">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-[#D76D77] mb-1">Last Name</label>
                            <input id="last_name" name="last_name" type="text" required
                                class="appearance-none bg-[#1E1E2E] relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-white rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm"
                                placeholder="Enter your last name">
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-[#D76D77] mb-1">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none bg-[#1E1E2E] relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-white rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-[#D76D77] mb-1">Phone Number</label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" required
                            class="appearance-none bg-[#1E1E2E] relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-white rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your phone number">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-[#D76D77] mb-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="appearance-none bg-[#1E1E2E] relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-white rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm"
                            placeholder="Create a password">
                    </div>
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-[#D76D77] mb-1">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" required
                            class="appearance-none bg-[#1E1E2E] relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-white rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm your password">
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-[#D76D77]">Emergency Contact</h3>
                    <p class="text-sm text-white">This information will be used only in emergency situations.</p>
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-[#D76D77] mb-1">Emergency Contact Name</label>
                        <input id="emergency_contact_name" name="emergency_contact_name" type="text"
                            class="appearance-none bg-[#1E1E2E] relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-white rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm"
                            placeholder="Enter emergency contact name">
                    </div>
                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-medium text-[#D76D77] mb-1">Emergency Contact Phone</label>
                        <input id="emergency_contact_phone" name="emergency_contact_phone" type="tel"
                            class="appearance-none bg-[#1E1E2E] relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-white rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm"
                            placeholder="Enter emergency contact phone">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                        class="h-4 w-4 bg-[#1E1E2E] text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-white">
                        I agree to the
                        <a href="#" class="font-medium text-[#D76D77] hover:text-[#D76D77] transition-colors duration-300">
                            Terms and Conditions
                        </a>
                        and
                        <a href="#" class="font-medium text-[#D76D77] hover:text-[#D76D77] transition-colors duration-300">
                            Privacy Policy
                        </a>
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:from-[#5A2E83] hover:to-[#E77D87] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                        Create Account
                    </button>
                </div>
            </form>

            <script>
                document.getElementById('signupForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = {
                        first_name: document.getElementById('first_name').value,
                        last_name: document.getElementById('last_name').value,
                        email: document.getElementById('email').value,
                        phone: document.getElementById('phone').value,
                        password: document.getElementById('password').value,
                        emergency_contact_name: document.getElementById('emergency_contact_name').value || null,
                        emergency_contact_phone: document.getElementById('emergency_contact_phone').value || null
                    };

                    fetch('../api/auth/signup.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success message
                            alert('Account created successfully! Please login to continue.');
                            // Clear the form
                            document.getElementById('signupForm').reset();
                        } else {
                            alert(data.message || 'An error occurred. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                });

                // Password confirmation validation
                document.getElementById('confirm_password').addEventListener('input', function() {
                    const password = document.getElementById('password').value;
                    const confirmPassword = this.value;
                    const submitButton = document.querySelector('button[type="submit"]');
                    
                    if (password !== confirmPassword) {
                        this.setCustomValidity('Passwords do not match');
                        submitButton.disabled = true;
                    } else {
                        this.setCustomValidity('');
                        submitButton.disabled = false;
                    }
                });
            </script>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div>
                    <h3 class="text-lg font-semibold text-pink-500 mb-4">About</h3>
                    <p class="text-gray-400">SheShield is dedicated to empowering and protecting women through technology and community support.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold text-pink-500 mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="about.html" class="text-gray-400 hover:text-pink-500 transition-colors">About Us</a></li>
                        <li><a href="report.html" class="text-gray-400 hover:text-pink-500 transition-colors">Report Incident</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold text-pink-500 mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="help.html" class="text-gray-400 hover:text-pink-500 transition-colors">Help Center</a></li>
                        <li><a href="contact.html" class="text-gray-400 hover:text-pink-500 transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Connect -->
                <div>
                    <h3 class="text-lg font-semibold text-pink-500 mb-4">Connect</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.398.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>