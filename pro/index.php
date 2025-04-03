<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SheShield - Women Safety Tool</title>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <!-- Tailwind CSS -->
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link href="/src/output.css" rel="stylesheet">
</head>
<body x-data="{ isMenuOpen: false }">
    <!-- Hero Section with Navigation -->
    <section class="relative h-[90vh] mb-10">
        <!-- Dark overlay with reduced opacity -->
        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <!-- Hero image with zoom effect -->
        <img src="/images/desktop-women4.png" alt="Hero" class="w-full h-full object-cover transform scale-100 hover:scale-105 transition-transform duration-3000">

        <!-- Navbar -->
        <div class="absolute top-0 left-0 w-full z-20">
            <nav class="bg-white shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo on the left -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="index.html" class="text-2xl font-bold text-pink-600">SheShield</a>
                        </div>
                        
                        <!-- Navigation links on the right -->
                        <div class="hidden sm:ml-auto sm:flex sm:items-center sm:space-x-8">
                            <a href="index.html" class="border-pink-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                            <a href="about.html" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">About</a>
                            <a href="report.html" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Report</a>
                            <a href="login.html" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Login</a>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="isMenuOpen = !isMenuOpen" type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500" aria-controls="mobile-menu" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <!--
                                  Heroicon name: outline/menu

                                  Menu open: "hidden", Menu closed: "block"
                                -->
                                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                                </svg>
                                <!--
                                  Heroicon name: outline/x

                                  Menu open: "block", Menu closed: "hidden"
                                -->
                                <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div x-show="isMenuOpen" class="sm:hidden bg-white border-t border-gray-200">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="index.html" class="block px-3 py-2 text-pink-600 font-semibold">Home</a>
                        <a href="about.html" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors">About</a>
                        <a href="report.html" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors">Report</a>
                        <a href="login.html" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors">Login</a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Hero Text Overlay with animations -->
        <div class="absolute inset-0 flex items-center justify-center z-10">
            <div class="text-center space-y-6">
                <h1 class="text-white text-3xl sm:text-5xl font-bold p-4 sm:p-8 md:p-10 border-2 backdrop-blur-sm
                           hover:scale-105 transition-transform duration-500
                           animate-[pulse_3s_ease-in-out_infinite]">
                    EMPOWER YOUR COMMUNITY,<br>ENSURE WOMEN'S SAFETY
                </h1>
                <a href="report.html" class="inline-block px-8 py-3 bg-pink-500 text-white font-semibold rounded-lg
                                          hover:bg-pink-600 transform hover:scale-105 transition-all duration-300
                                          shadow-lg hover:shadow-xl">
                    Report an Incident
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="text-center flex flex-col sm:flex-row p-8 sm:p-20">
        <div class="w-full sm:w-1/2 overflow-hidden rounded-2xl shadow-lg group">
            <img src="/images/desktop-women.jpg" alt="Women Empowerment" 
                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
        </div>
        <div class="w-full sm:w-1/2 text-left sm:text-left mt-6 sm:mt-0 sm:pl-12">
            <div class="relative">
                <h2 class="text-3xl sm:text-4xl font-semibold mt-6 sm:mt-28 p-4 sm:p-10
                          bg-clip-text text-transparent bg-gradient-to-r from-pink-600 to-purple-600
                          transform hover:scale-105 transition-transform duration-300">
                    RESPECT, PROTECT, EMPOWER WITH SHESHIELD
                </h2>
                <div class="absolute -bottom-2 left-4 sm:left-10 w-24 h-1 bg-pink-500"></div>
            </div>
            <p class="text-gray-600 mt-4 mb-8 sm:mb-28 px-4 sm:px-9 leading-relaxed
                      hover:text-gray-900 transition-colors duration-300">
                Designed to connect, protect, and empower, the platform integrates advanced features for seamless reporting, 
                instant alerts, and community support. SheShield ensures privacy through anonymous reporting options and 
                strengthens reports with secure evidence uploads, such as images, videos, or documents.
            </p>
            <div class="px-4 sm:px-9 space-y-4">
                <div class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center
                               group-hover:bg-pink-200 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="text-gray-700 group-hover:text-pink-600 transition-colors duration-300">Secure and Anonymous Reporting</span>
                </div>
                <div class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center
                               group-hover:bg-pink-200 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-gray-700 group-hover:text-pink-600 transition-colors duration-300">24/7 Community Support</span>
                </div>
                <div class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center
                               group-hover:bg-pink-200 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </div>
                    <span class="text-gray-700 group-hover:text-pink-600 transition-colors duration-300">Instant Emergency Response</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="my-16 sm:px-24 px-10">
        <h3 class="text-3xl font-bold text-center mb-10 relative">
            Our Features
            <div class="absolute w-24 h-1 bg-pink-500 bottom-0 left-1/2 transform -translate-x-1/2 mt-2"></div>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group p-6 bg-gradient-to-br from-pink-50 to-purple-50 rounded-lg shadow-md 
                        hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="text-4xl mb-4 text-center group-hover:scale-110 transition-transform duration-300">📋</div>
                <h4 class="text-xl font-bold text-center mb-2 text-gray-800 group-hover:text-pink-600 transition-colors duration-300">Incident Reporting</h4>
                <p class="text-gray-600 text-center group-hover:text-gray-800 transition-colors duration-300">
                    Easily report safety concerns with a seamless and user-friendly interface.
                </p>
            </div>
            <!-- Feature 2 -->
            <div class="group p-6 bg-gradient-to-br from-pink-50 to-purple-50 rounded-lg shadow-md 
                        hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="text-4xl mb-4 text-center group-hover:scale-110 transition-transform duration-300">🗣️</div>
                <h4 class="text-xl font-bold text-center mb-2 text-gray-800 group-hover:text-pink-600 transition-colors duration-300">Voice-to-Text Input</h4>
                <p class="text-gray-600 text-center group-hover:text-gray-800 transition-colors duration-300">
                    Report incidents using voice with automatic text conversion.
                </p>
            </div>
            <!-- Feature 3 -->
            <div class="group p-6 bg-gradient-to-br from-pink-50 to-purple-50 rounded-lg shadow-md 
                        hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="text-4xl mb-4 text-center group-hover:scale-110 transition-transform duration-300">🤝</div>
                <h4 class="text-xl font-bold text-center mb-2 text-gray-800 group-hover:text-pink-600 transition-colors duration-300">Support Networks</h4>
                <p class="text-gray-600 text-center group-hover:text-gray-800 transition-colors duration-300">
                    Connect with legal aid, counseling, and local support networks.
                </p>
            </div>
            <!-- Feature 4 -->
            <div class="group p-6 bg-gradient-to-br from-pink-50 to-purple-50 rounded-lg shadow-md 
                        hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="text-4xl mb-4 text-center group-hover:scale-110 transition-transform duration-300">💬</div>
                <h4 class="text-xl font-bold text-center mb-2 text-gray-800 group-hover:text-pink-600 transition-colors duration-300">Feedback System</h4>
                <p class="text-gray-600 text-center group-hover:text-gray-800 transition-colors duration-300">
                    Provide feedback to continuously improve the platform.
                </p>
            </div>
            <!-- Feature 5 -->
            <div class="group p-6 bg-gradient-to-br from-pink-50 to-purple-50 rounded-lg shadow-md 
                        hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="text-4xl mb-4 text-center group-hover:scale-110 transition-transform duration-300">🔒</div>
                <h4 class="text-xl font-bold text-center mb-2 text-gray-800 group-hover:text-pink-600 transition-colors duration-300">Secure Evidence Upload</h4>
                <p class="text-gray-600 text-center group-hover:text-gray-800 transition-colors duration-300">
                    Upload and store evidence securely with encryption.
                </p>
            </div>
            <!-- Feature 6 -->
            <div class="group p-6 bg-gradient-to-br from-pink-50 to-purple-50 rounded-lg shadow-md 
                        hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="text-4xl mb-4 text-center group-hover:scale-110 transition-transform duration-300">🙈</div>
                <h4 class="text-xl font-bold text-center mb-2 text-gray-800 group-hover:text-pink-600 transition-colors duration-300">Anonymous Reporting</h4>
                <p class="text-gray-600 text-center group-hover:text-gray-800 transition-colors duration-300">
                    Report incidents anonymously with complete privacy.
                </p>
            </div>
        </div>
    </section>

    <!-- AI Chatbot -->
    <div x-data="{ 
        isOpen: false,
        userInput: '',
        selectedLanguage: 'en',
        messages: [
            {
                id: 1,
                type: 'bot',
                text: 'Hello! I\'m your SheShield AI assistant. How can I help you today?',
                options: [
                    'I need immediate help',
                    'Legal information',
                    'Emotional support',
                    'Report an incident'
                ]
            }
        ]
    }" 
    class="fixed bottom-4 right-4 z-50 flex flex-col items-end">
        <!-- Chat Button -->
        <button @click="isOpen = !isOpen" 
                class="bg-pink-600 text-white rounded-full p-4 shadow-lg hover:bg-pink-700 transition-all duration-300 mb-2">
            <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            <svg x-show="isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Chat Window -->
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="bg-white rounded-lg shadow-xl w-96 max-w-full mb-4"
             @click.away="isOpen = false">
            <!-- Chat Header -->
            <div class="bg-pink-600 text-white p-4 rounded-t-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-bold">SheShield AI Assistant</h3>
                        <p class="text-sm text-pink-100">24/7 Support & Guidance</p>
                    </div>
                    <select x-model="selectedLanguage" 
                            class="text-sm bg-pink-700 text-white rounded px-2 py-1 border border-pink-400">
                        <option value="en">English</option>
                        <option value="hi">हिंदी</option>
                        <option value="es">Español</option>
                        <option value="fr">Français</option>
                        <option value="zh">中文</option>
                    </select>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="h-96 overflow-y-auto p-4 space-y-4" id="chat-messages">
                <template x-for="message in messages" :key="message.id">
                    <div :class="{'flex justify-end': message.type === 'user', 'flex justify-start': message.type === 'bot'}">
                        <div :class="{
                            'bg-pink-600 text-white': message.type === 'user',
                            'bg-gray-100 text-gray-800': message.type === 'bot'
                        }" class="rounded-lg px-4 py-2 max-w-[80%]">
                            <p x-text="message.text"></p>
                            <template x-if="message.type === 'bot' && message.options">
                                <div class="mt-2 space-y-2">
                                    <template x-for="option in message.options" :key="option">
                                        <button @click="userInput = option; $nextTick(() => { messages.push({ id: Date.now(), type: 'user', text: option }); messages.push({ id: Date.now() + 1, type: 'bot', text: 'How can I assist you further?', options: ['Emergency help', 'Legal support', 'Emotional support', 'Report incident'] }); })"
                                                class="block w-full text-left text-sm text-pink-600 hover:bg-pink-50 rounded px-2 py-1 transition-colors">
                                            <span x-text="option"></span>
                                        </button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Chat Input -->
            <div class="border-t p-4">
                <div class="flex space-x-2">
                    <input type="text" 
                           x-model="userInput" 
                           @keydown.enter="messages.push({ id: Date.now(), type: 'user', text: userInput }); messages.push({ id: Date.now() + 1, type: 'bot', text: 'How can I assist you further?', options: ['Emergency help', 'Legal support', 'Emotional support', 'Report incident'] }); userInput = ''"
                           placeholder="Type your message..."
                           class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <button @click="messages.push({ id: Date.now(), type: 'user', text: userInput }); messages.push({ id: Date.now() + 1, type: 'bot', text: 'How can I assist you further?', options: ['Emergency help', 'Legal support', 'Emotional support', 'Report incident'] }); userInput = ''"
                            class="bg-pink-600 text-white rounded-lg px-4 py-2 hover:bg-pink-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
            </div>
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
                        <li><a href="login.html" class="text-gray-400 hover:text-pink-500 transition-colors">Login</a></li>
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
                                <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Chatbot Script -->
    <script>
        const chatbot = {
            greetings: [
                "Hello! I'm SheShield's AI assistant. I'm here to help you stay safe and informed. How can I assist you today?",
                "Welcome to SheShield! I'm your personal safety assistant. What would you like to know?",
                "Hi there! I'm here to provide support and information about personal safety. How may I help you?"
            ],

            responses: {
                "help": {
                    keywords: ["help", "assistance", "support"],
                    reply: `I understand you need help. Let me guide you through our support options:

1. Emergency Assistance:
   • Immediate Danger: Call 112 (All-India Emergency)
   • Police: 100
   • Women's Helpline: 1091
   • Ambulance: 102
   • Fire: 101

2. Support Services:
   • 24/7 Women's Helpline: 1091
   • Domestic Violence Helpline: 181
   • NCW WhatsApp Help: 7217735372

3. How would you like me to help you?
   • Need immediate emergency assistance
   • Want to report an incident
   • Looking for safety tips
   • Need legal information
   • Need emotional support

Please select one of these options or tell me more about your situation.`
                },
                "emergency": {
                    keywords: ["emergency", "danger", "urgent", "immediate"],
                    reply: ` EMERGENCY PROTOCOL ACTIVATED 

1. IMMEDIATE ACTIONS:
   • If in immediate danger, call 112 NOW
   • Police: 100
   • Women's Helpline: 1091
   • Ambulance: 102

2. SAFETY STEPS:
   • Get to a safe location if possible
   • Stay on the line with emergency services
   • Make noise to attract attention if needed
   • Use SheShield's SOS feature if available

3. WHILE WAITING FOR HELP:
   • Stay on the phone with emergency services
   • Keep your location services on
   • Document any evidence if safe to do so
   • Contact trusted friends/family

Do you need me to:
• Guide you through contacting emergency services
• Help you use SheShield's SOS feature
• Connect you with local support services
• Provide specific safety instructions

Please let me know what you need right now.`
                },
                "report": {
                    keywords: ["report", "incident", "complaint", "file"],
                    reply: `I'll help you report an incident. Here's what you need to know:

1. REPORTING OPTIONS:
   • Anonymous Report: No personal details required
   • Detailed Report: With contact information
   • Police Report: Direct to law enforcement
   • NCW Report: National Commission for Women

2. WHAT TO INCLUDE:
   • Type of incident
   • Date and time
   • Location details
   • Description of what happened
   • Any evidence (photos, videos, messages)
   • Witness information (if any)

3. REPORTING PROCESS:
   • Click "Report" in the navigation menu
   • Choose anonymous or identified report
   • Fill in the incident details
   • Add any supporting evidence
   • Submit the report

4. AFTER REPORTING:
   • You'll receive a unique report ID
   • Track your report status
   • Get updates on actions taken
   • Access support services

Would you like me to:
• Guide you through filing a report now
• Explain more about the reporting process
• Connect you with a support advocate
• Provide information about your rights

What would be most helpful?`
                },
                "safety": {
                    keywords: ["safety", "protect", "secure", "prevention", "tips"],
                    reply: `Here are comprehensive safety guidelines:

1. PERSONAL SAFETY:
   • Stay aware of surroundings
   • Trust your instincts
   • Walk confidently and purposefully
   • Vary your routine
   • Keep emergency contacts on speed dial
   • Share location with trusted contacts

2. DIGITAL SAFETY:
   • Use strong, unique passwords
   • Enable two-factor authentication
   • Be careful with personal information
   • Check privacy settings regularly
   • Be cautious with unknown links
   • Monitor your digital footprint

3. TRAVEL SAFETY:
   • Plan routes in advance
   • Stay in well-lit areas
   • Use trusted transportation
   • Share trip details with trusted contacts
   • Keep emergency numbers handy
   • Use SheShield's tracking feature

4. HOME SAFETY:
   • Secure all entries
   • Install good lighting
   • Know your neighbors
   • Have an emergency plan
   • Keep emergency supplies ready

Would you like specific details about:
• Personal safety techniques
• Digital security measures
• Safe travel practices
• Home security tips
• Emergency preparedness

What area of safety would you like to focus on?`
                },
                "legal": {
                    keywords: ["legal", "rights", "law", "justice"],
                    reply: `Understanding your legal rights is crucial. Here's what you need to know:

1. FUNDAMENTAL RIGHTS:
   • Right to file an FIR
   • Right to zero FIR (file anywhere)
   • Right to legal representation
   • Right to medical examination
   • Right to privacy and confidentiality

2. WORKPLACE RIGHTS:
   • Protection against harassment
   • Safe working environment
   • Equal opportunities
   • Maternity benefits
   • Sexual harassment committee

3. DOMESTIC RIGHTS:
   • Protection against domestic violence
   • Right to residence
   • Maintenance and alimony
   • Child custody rights
   • Protection orders

4. LEGAL RESOURCES:
   • Free legal aid
   • Women's commission support
   • NGO assistance
   • Police assistance
   • Court support services

Would you like to:
• Learn more about specific rights
• Connect with legal aid
• Get guidance on filing complaints
• Understand protection orders
• Find legal resources near you

How can I help you with legal matters?`
                },
                "support": {
                    keywords: ["emotional", "counseling", "therapy", "talk"],
                    reply: `You're not alone. Here's how we can support you:

1. IMMEDIATE SUPPORT:
   • 24/7 Emotional Support Helpline: 1098
   • Crisis Counseling: Available Now
   • Online Support Groups
   • Professional Counselors

2. SUPPORT SERVICES:
   • One-on-one counseling
   • Group therapy sessions
   • Trauma support
   • Family counseling
   • Peer support groups

3. COPING STRATEGIES:
   • Deep breathing exercises
   • Grounding techniques
   • Mindfulness practices
   • Stress management
   • Self-care routines

Would you like to:
• Talk to a counselor now
• Join a support group
• Learn coping techniques
• Find local support services
• Get self-help resources

How can I best support you right now?`
                }
            },

            findResponse(input) {
                input = input.toLowerCase();
                
                // Check for exact matches first
                for (const category in this.responses) {
                    const keywords = this.responses[category].keywords;
                    if (keywords.some(keyword => input.includes(keyword))) {
                        return this.responses[category].reply;
                    }
                }

                // If no exact match, provide a helpful default response
                return `I'm here to help you. Please let me know what you need:

1. EMERGENCY ASSISTANCE:
   • If you're in immediate danger
   • Need urgent help
   • Medical emergency
   • Police assistance

2. INCIDENT REPORTING:
   • File a complaint
   • Document an incident
   • Track a report
   • Update existing report

3. SAFETY INFORMATION:
   • Personal safety tips
   • Digital security
   • Travel safety
   • Home security

4. SUPPORT SERVICES:
   • Legal assistance
   • Emotional support
   • Counseling services
   • Support groups

5. RESOURCES:
   • Helpline numbers
   • Support organizations
   • Legal aid
   • Medical services

Please tell me what type of help you need, or click one of the quick action buttons below.`;
            }
        };

        function handleQuickAction(action) {
            const actionMessages = {
                'emergency': 'I need emergency help',
                'report': 'How do I report an incident?',
                'safety': 'Can you provide safety tips?',
                'rights': 'What are my legal rights?'
            };
            
            const message = actionMessages[action];
            appendMessage('user', message);
            showTypingIndicator();
            
            setTimeout(() => {
                removeTypingIndicator();
                const response = chatbot.findResponse(message);
                appendMessage('bot', response);
            }, 1000);
        }

        function showTypingIndicator() {
            const chatMessages = document.getElementById('chat-messages');
            const typingDiv = document.createElement('div');
            typingDiv.id = 'typing-indicator';
            typingDiv.className = 'flex mb-3';
            typingDiv.innerHTML = `
                <div class="bg-gray-200 rounded-lg py-2 px-4">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            `;
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function removeTypingIndicator() {
            const indicator = document.getElementById('typing-indicator');
            if (indicator) {
                indicator.remove();
            }
        }

        function appendMessage(sender, message) {
            const chatMessages = document.getElementById('chat-messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = sender === 'bot' ? 
                'flex mb-3' : 
                'flex mb-3 justify-end';
            
            const messageBubble = document.createElement('div');
            messageBubble.className = sender === 'bot' ? 
                'bg-gray-200 rounded-lg py-2 px-4 max-w-[80%]' : 
                'bg-pink-500 text-white rounded-lg py-2 px-4 max-w-[80%]';
            
            // Format message with proper styling
            const formattedMessage = message.split('\n').map(line => {
                const trimmedLine = line.trim();
                if (trimmedLine.match(/^\d+\./)) {
                    // Section headers
                    return `<div class="font-bold text-lg mt-2 mb-1">${trimmedLine}</div>`;
                } else if (trimmedLine.startsWith('•')) {
                    // Bullet points
                    return `<div class="ml-4 my-1">${trimmedLine}</div>`;
                } else if (trimmedLine.match(/^[A-Z\s]+:/)) {
                    // Category headers
                    return `<div class="font-bold mt-3 mb-1">${trimmedLine}</div>`;
                }
                return `<div>${trimmedLine}</div>`;
            }).join('');
            
            messageBubble.innerHTML = formattedMessage;
            messageDiv.appendChild(messageBubble);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function handleUserInput(event) {
            event.preventDefault();
            const input = document.getElementById('user-input');
            const message = input.value.trim();
            
            if (message) {
                appendMessage('user', message);
                showTypingIndicator();
                
                setTimeout(() => {
                    removeTypingIndicator();
                    const response = chatbot.findResponse(message);
                    appendMessage('bot', response);
                }, 1000 + Math.random() * 1000);
                
                input.value = '';
            }
        }

        // Initialize chatbot when page loads
        window.addEventListener('load', () => {
            const greeting = chatbot.greetings[Math.floor(Math.random() * chatbot.greetings.length)];
            appendMessage('bot', greeting);
        });
    </script>
</body>
</html>