<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Templates</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .sidebar-hidden { transform: translateX(-100%); }
        .sidebar-visible { transform: translateX(0); }
        .toggle-moved { transform: translateX(16rem) translateY(-50%); }
        .toggle-default { transform: translateX(0) translateY(-50%); }
        .content-shifted { margin-left: 16rem; }
        .content-full { margin-left: 0; }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-none {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-[#F9E9F0] text-[#333333]">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed w-64 bg-[#D12E79] text-white p-5 flex flex-col h-full z-40 transition-transform duration-300 ease-in-out sidebar-hidden md:sidebar-visible">
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
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='dashboard.php'">
                        <i class="fa-solid fa-house"></i> <span>Home</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer" onclick="location.href='report.php'">
                        <i class="fa-solid fa-file"></i> <span>Reports</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
                        <i class="fa-solid fa-chart-bar"></i> <span>Analytics</span>
                    </li>
                    <li class="p-3 rounded flex items-center space-x-2 hover:bg-[#AB1E5C] cursor-pointer">
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
                </ul>
            </nav>
        </aside>

        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" class="fixed left-0 top-1/2 bg-[#D12E79] text-white p-2 rounded-r z-50 transition-transform duration-300 ease-in-out toggle-default md:toggle-moved">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-8 transition-all duration-300 ease-in-out content-full md:content-shifted overflow-y-auto h-screen">
            <div id="content" class="min-h-full">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-[#D12E79] to-[#AB1E5C] bg-clip-text text-transparent">Templates</h1>
                <div class="absolute top-8 right-8 z-10 w-72">
                    <div class="relative">
                        <select class="w-full px-4 py-2 rounded-lg border-2 border-[#D12E79] focus:outline-none focus:ring-2 focus:ring-[#AB1E5C] text-[#D12E79]" id="categoryFilter">
                            <option value="all">All Categories</option>
                            <option value="Harassment">Harassment</option>
                            <option value="Stalking">Stalking</option>
                            <option value="Theft">Theft</option>
                            <option value="Assault">Assault</option>
                        </select>
                        <i class="fa-solid fa-search absolute right-3 top-3 text-[#D12E79]"></i>
                    </div>
                </div>
                <p class="mt-2">Manage your templates here.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
                    <div class="bg-gradient-to-b from-blue-100 to-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] hover:bg-white focus:outline-none focus:ring-2 focus:ring-[#D12E79] focus:ring-offset-2" data-category="Harassment">
                        <h2 class="text-xl font-semibold mb-3">Complaint Regarding Inadequate Response to Safety Concerns by University Staff</h2>
                        <p class="text-gray-600 mb-4">Formal complaint template for reporting inadequate responses to safety concerns by university authorities.</p>
                        <div class="h-12 flex items-center">
                            <button class="bg-[#D12E79] text-white px-6 py-3 rounded-lg hover:bg-[#AB1E5C] transition-all duration-300 focus:ring-2 focus:ring-[#D12E79] focus:ring-offset-2 template-button">Use Template</button>
                        </div>
                    </div>
                    <div class="bg-gradient-to-b from-blue-100 to-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] hover:bg-white" data-category="Assault">
                        <h2 class="text-xl font-semibold mb-3">Complaint Regarding Blackmail and Threat</h2>
                        <p class="text-gray-600 mb-4">Template for reporting blackmail and and threat on campus.</p>
                        <div class="h-12 flex items-center">
                            <button class="bg-[#D12E79] text-white px-6 py-3 rounded-lg hover:bg-[#AB1E5C] transition-all duration-300 focus:ring-2 focus:ring-[#D12E79] focus:ring-offset-2 template-button">Use Template</button>
                        </div>
                    </div>
                    <div class="bg-gradient-to-b from-blue-100 to-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] hover:bg-white" data-category="Assault">
                        <h2 class="text-xl font-semibold mb-3">Complaint Regarding Sexual Harassment Incident</h2>
                        <p class="text-gray-600 mb-4">Formal template for documenting and reporting sexual harassment incidents with evidentiary support.</p>
                        <div class="h-12 flex items-center">
                            <button class="bg-[#D12E79] text-white px-6 py-3 rounded-lg hover:bg-[#AB1E5C] transition-all duration-300 focus:ring-2 focus:ring-[#D12E79] focus:ring-offset-2 template-button">Use Template</button>
                        </div>
                    </div>
                    <div class="bg-gradient-to-b from-blue-100 to-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] hover:bg-white mt-6 md:mt-0" data-category="Stalking">
                        <h2 class="text-xl font-semibold mb-3">Complaint Regarding Stalking Incident</h2>
                        <p class="text-gray-600 mb-4">Template for reporting persistent stalking behavior with timeline documentation.</p>
                        <div class="h-12 flex items-center">
                            <button class="bg-[#D12E79] text-white px-6 py-3 rounded-lg hover:bg-[#AB1E5C] transition-all duration-300 focus:ring-2 focus:ring-[#D12E79] focus:ring-offset-2 template-button">Use Template</button>
                        </div>
                    </div>
                    <div class="bg-gradient-to-b from-blue-100 to-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] hover:bg-white mt-6 md:mt-0" data-category="Stalking">
                        <h2 class="text-xl font-semibold mb-3">Complaint Regarding Eve-Teasing</h2>
                        <p class="text-gray-600 mb-4">Template for reporting instances of eve-teasing and street harassment.</p>
                        <div class="h-12 flex items-center">
                            <button class="bg-[#D12E79] text-white px-6 py-3 rounded-lg hover:bg-[#AB1E5C] transition-all duration-300 focus:ring-2 focus:ring-[#D12E79] focus:ring-offset-2 template-button">Use Template</button>
                        </div>
                    </div>
                    <div class="bg-gradient-to-b from-blue-100 to-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] hover:bg-white mt-6 md:mt-0" data-category="Stalking">
                        <h2 class="text-xl font-semibold mb-3">Complaint Regarding Offensive Comments or Remarks</h2>
                        <p class="text-gray-600 mb-4">Template for documenting and reporting offensive verbal comments or derogatory remarks.</p>
                        <div class="h-12 flex items-center">
                            <button class="bg-[#D12E79] text-white px-6 py-3 rounded-lg hover:bg-[#AB1E5C] transition-all duration-300 focus:ring-2 focus:ring-[#D12E79] focus:ring-offset-2 template-button">Use Template</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="templateModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl flex flex-col max-h-[80vh] overflow-y-auto scrollbar-none border-2 border-[#D12E79]">
        <div class="sticky top-0 bg-white border-b p-6 flex justify-between items-center border-gradient">
            <div class="flex items-center space-x-3">
                <i class="fas fa-file-alt text-2xl text-[#D12E79]"></i>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-[#D12E79] to-[#AB1E5C] bg-clip-text text-transparent drop-shadow-lg">Complaint Template</h2>
            </div>
            <div class="flex items-center space-x-4">
                <button onclick="copyApplication()" class="p-2 hover:bg-[#F9E9F0] rounded-full transition-colors duration-200 group relative" aria-label="Copy template">
                    <i class="fas fa-copy text-xl text-[#D12E79] group-hover:text-[#AB1E5C] transition-colors"></i>
                    <span class="absolute -bottom-8 right-0 bg-gray-800 text-white text-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-lg">Copy template</span>
                </button>
                <button onclick="closeModal()" class="p-2 hover:bg-[#F9E9F0] rounded-full transition-colors duration-200 group relative" aria-label="Close modal">
                    <i class="fas fa-times text-xl text-[#D12E79] group-hover:text-[#AB1E5C] transition-colors"></i>
                    <span class="absolute -bottom-8 right-0 bg-gray-800 text-white text-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">Close</span>
                </button>
            </div>
        </div>
        <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Inappropriate Behavior</h2>
        <div class="space-y-6">
        <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
            <p>To,</p>
            <p>The Anti-Ragging Cell,</p>
            <p>[University Name],</p>
            <p>[Address]</p>
            <p class="mt-4">Subject: Complaint Regarding Inappropriate Behavior by a Male Student</p>
            <p class="mt-4">Respected Sir/Madam,</p>
            <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], am writing to report an incident involving inappropriate behavior by a male student, [Name if known], on [Date] at [Location]. The male student was [describe the inappropriate behavior, e.g., following, making unsolicited comments, etc.], which made me feel uncomfortable and unsafe on campus.</p>
            <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Details:</h3>
            <p>Type of Incident: Inappropriate Behavior / Ragging</p>
            <p>Incident Description: [Provide a detailed account of the behavior, e.g., harassment, derogatory comments]</p>
            <p>Perpetrator: [Name of the student if known]</p>
            <p>Location: [Location of the incident on campus]</p>
            <p>Time of Incident: [Time of incident]</p>
            <p>Witnesses (if any): [Optional]</p>
            <p class="mt-4">I kindly request the Anti-Ragging Cell to take immediate action according to university regulations and ensure that this student's actions are addressed as per the law. I have attached any available evidence to substantiate my complaint.</p>
            <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Supporting Documents:</h3>
            <p>[List of documents or evidence, if any]</p>
            <p class="mt-4">Thank you for your prompt attention to this matter. I hope to receive a response at the earliest.</p>
            <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="font-medium text-gray-600">Sincerely,</p>
            <p>[Your Name / Anonymous]</p>
            <p>[Student ID and Department]</p>

        </div>
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal when clicking outside
            const templateModal = document.getElementById('templateModal');
            templateModal.addEventListener('click', function(e) {
                if (e.target === templateModal) {
                    closeModal();
                }
            });
            // Add event listeners for template buttons
            document.querySelectorAll('.template-button').forEach(button => {
                button.addEventListener('click', () => {
                    showModal();
                    const templateName = button.parentElement.querySelector('h2').textContent.trim();
                    const modalContent = document.querySelector('#templateModal .bg-white');
                    
                    // Template content mapping
                    let templateHTML = '';
                    switch(templateName) {
                        case 'Complaint Regarding Eve-Teasing':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Eve-Teasing/Harassment</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>The Dean of Students,</p>
                                        <p>[University Name],</p>
                                        <p>[Address]</p>
                                        <p class="mt-4">Subject: Complaint Regarding Eve-Teasing Incident</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], enrolled in [Course Name], am submitting this complaint regarding an incident of eve-teasing/harassment that occurred on [Date] at [Location], involving a male student from [Name of Department/Year, if known].</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Details of the Incident:</h3>
                                        <p>Type of Incident: Eve-Teasing / Harassment</p>
                                        <p>Incident Description: On [Date], while I was [describe the situation], [Male Student’s Name] approached me and made inappropriate comments/gestures [give details].</p>
                                        <p>Location: [Specific location in the campus]</p>
                                        <p>Time: [Time of the incident]</p>
                                        <p>Perpetrator: [Name if known]</p>
                                        <p>Witnesses (if any): [Optional]</p>
                                        <p class="mt-4">I request that the university authorities take swift action in addressing this incident and prevent recurrence. Attached evidence for reference.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Attachments:</h3>
                                        <p>[List of evidence]</p>
                                        <div class="mt-8 pt-6 border-t border-gray-200">
                                            <p class="font-medium text-gray-600">Sincerely,</p>
                                            <p>[Your Name / Anonymous]</p>
                                            <p>[Student ID and Department]</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;
                        case 'Complaint Regarding Offensive Comments or Remarks':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Offensive Behavior by a Male Student on Campus</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>The Anti-Ragging Cell / Disciplinary Committee,</p>
                                        <p>[University Name],</p>
                                        <p>[University Address]</p>
                                        <p class="mt-4">Subject: Formal Complaint Regarding Offensive Behavior by a Male Student</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], am writing to formally report an incident of offensive and inappropriate behavior by a male student, [Offender’s Name (if known)], that took place on [Date] at [Location] within the university premises.</p>
                                        <p class="mt-4 text-gray-600">This incident has left me feeling unsafe and uncomfortable, and I strongly believe that immediate disciplinary action is necessary to ensure that such behavior is not repeated, either against me or any other female student on campus.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Details of the Incident:</h3>
                                        <p>Type of Incident: Offensive Behavior / Harassment / Misconduct</p>
                                        <p>Incident Date: [DD/MM/YYYY]</p>
                                        <p>Time of Incident: [HH:MM AM/PM]</p>
                                        <p>Location: [Specify location]</p>
                                        <p>Perpetrator’s Name (if known): [Student’s Name]</p>
                                        <p>Student’s Department and Year (if known): [Department Name, Year of Study]</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Description:</h3>
                                        <p class="mt-4 text-gray-600">On [Date], at approximately [Time], I was [mention activity] when I encountered [Offender’s Name]. Without any provocation, he [describe behavior details].</p>
                                        <p class="mt-4 text-gray-600">Despite my clear discomfort and efforts to ignore him, he continued to [describe persistent actions].</p>
                                        <div class="mt-8 pt-6 border-t border-gray-200">
                                            <p class="font-medium text-gray-600">Sincerely,</p>
                                            <p>[Your Name / Anonymous]</p>
                                            <p>[Your Contact Information (if comfortable sharing)]</p>
                                            <p>[Department Name, University Name]</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;
                        case 'Complaint Regarding Inadequate Response to Safety Concerns by University Staff':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Inadequate Response to Safety Concerns</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>[University Authority Name]</p>
                                        <p>[University Name]</p>
                                        <p>[Address]</p>
                                        <p class="mt-4">Subject: Complaint Regarding Inadequate Response to Safety Concerns by University Staff on [Date]</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], am writing to report my dissatisfaction with the inadequate response from university staff regarding my previous safety concerns. On [Date], I approached [Staff Member's Name / Department] regarding [Nature of Concern], but the response was unsatisfactory and did not address my concerns adequately.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Details of the Incident:</h3>
                                        <p>Type of Concern: Inadequate Response to Safety Concern</p>
                                        <p>Concern Description: [User Input]</p>
                                        <p>Staff Involved (if known): [Optional Input]</p>
                                        <p>Follow-Up (if any): [Optional Input]</p>
                                        <p class="mt-6 text-gray-600">I request that immediate action be taken to address the lack of response and that proper measures are put in place to ensure female students are supported effectively. I have attached evidence related to the incident.</p>
                                        <p>Attachments: [Screenshots, Videos, etc.]</p>
                                        <div class="mt-8 pt-6 border-t border-gray-200">
                                            <p class="font-medium text-gray-600">Sincerely,</p>
                                            <p>[Your Name / Anonymous]</p>
                                            <p>[Your Contact Information (if comfortable sharing)]</p>
                                            <p>[Department Name, University Name]</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;
                        case 'Complaint Regarding Offensive Comments or Remarks':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Offensive Behavior by a Male Student on Campus</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>The Anti-Ragging Cell / Disciplinary Committee,</p>
                                        <p>[University Name],</p>
                                        <p>[University Address]</p>
                                        <p class="mt-4">Subject: Formal Complaint Regarding Offensive Behavior by a Male Student</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], am writing to formally report an incident of offensive and inappropriate behavior by a male student, [Offender’s Name (if known)], that took place on [Date] at [Location] within the university premises.</p>
                                        <p class="mt-4 text-gray-600">This incident has left me feeling unsafe and uncomfortable, and I strongly believe that immediate disciplinary action is necessary to ensure that such behavior is not repeated, either against me or any other female student on campus.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Details of the Incident:</h3>
                                        <p>Type of Incident: Offensive Behavior / Harassment / Misconduct</p>
                                        <p>Incident Date: [DD/MM/YYYY]</p>
                                        <p>Time of Incident: [HH:MM AM/PM]</p>
                                        <p>Location: [Specify location]</p>
                                        <p>Perpetrator’s Name (if known): [Student’s Name]</p>
                                        <p>Student’s Department and Year (if known): [Department Name, Year of Study]</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Description:</h3>
                                        <p class="mt-4 text-gray-600">On [Date], at approximately [Time], I was [mention activity] when I encountered [Offender’s Name]. Without any provocation, he [describe behavior details].</p>
                                        <p class="mt-4 text-gray-600">Despite my clear discomfort and efforts to ignore him, he continued to [describe persistent actions].</p>
                                    </div>
                                </div>
                            `;
                        case 'Complaint Regarding Sexual Harassment Incident':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Sexual Harassment Incident</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>[University Authority Name]</p>
                                        <p>[University Name]</p>
                                        <p>[Address]</p>
                                        <p class="mt-4">Subject: Urgent Complaint Regarding Sexual Harassment Incident on [Date]</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], am writing to formally report an incident of sexual harassment that took place on [Date] at [Location] within the university premises. This incident has caused me immense distress, and I request immediate action in accordance with the university’s anti-harassment policies.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Details:</h3>
                                        <p>Type of Incident: Sexual Harassment</p>
                                        <p>Date & Time: [Date] at [Time]</p>
                                        <p>Location: [Specify exact location]</p>
                                        <p>Perpetrator (if known): [Name/Description (if available)]</p>
                                        <p>Witnesses (if any): [Names/Details (if available)]</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Description:</h3>
                                        <p class="text-gray-600">[Provide a clear and concise account of what happened—describe the nature of the harassment (verbal, physical, non-verbal gestures, inappropriate messages, etc.), how it occurred, and how it made you feel. Mention if the harassment has been ongoing or if this was an isolated incident. If you tried to stop the behavior and the perpetrator continued, include that information.]</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Attachments (if any):</h3>
                                        <p class="text-gray-600">[Attach any relevant evidence, such as screenshots, emails, messages, photos, or video recordings.]</p>
                                        <div class="mt-8 pt-6 border-t border-gray-200">
                                            <p class="text-gray-600">I request a prompt and serious response to this matter. Please confirm receipt of this complaint and inform me about the steps being taken. I am willing to cooperate in the investigation while maintaining confidentiality for my safety.</p>
                                            <p class="font-medium text-gray-600 mt-4">Sincerely,</p>
                                            <p>[Your Name / Anonymous]</p>
                                            <p>[Your Contact Information (if comfortable sharing)]</p>
                                            <p>[Department Name, University Name]</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;
                        case 'Complaint Regarding Blackmail and Threat':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Blackmail and Threats by a Fellow Student</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>The University Administration,</p>
                                        <p>[University Name],</p>
                                        <p>[University Address]</p>
                                        <p class="mt-4">Subject: Formal Complaint Against Blackmail and Threats by a Student</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name], a student of [Department Name], am writing to formally report a serious issue of blackmail and threats by [Offender’s Name], a fellow student at [University Name].</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Details of the Incident:</h3>
                                        <ul class="list-disc pl-6 space-y-2">
                                            <li>Nature of the Complaint: Blackmail / Intimidation</li>
                                            <li>Date of Incident: [DD/MM/YYYY]</li>
                                            <li>Location: [Specify]</li>
                                            <li>Perpetrator’s Name (if known): [Name]</li>
                                        </ul>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Description:</h3>
                                        <ul class="list-disc pl-6 space-y-2">
                                            <li>[Offender’s Name] has obtained personal information/images/conversations related to me and is threatening to release them publicly unless I comply with [their demands].</li>
                                            <li>The blackmail has caused severe mental distress.</li>
                                            <li>The person has made multiple threats in person and online.</li>
                                            <li>I fear for my privacy, security, and reputation on campus.</li>
                                        </ul>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Requested Actions:</h3>
                                        <ul class="list-disc pl-6 space-y-2">
                                            <li>Investigate the source and nature of threats.</li>
                                            <li>Take immediate disciplinary action against the offender.</li>
                                            <li>Provide security assistance to ensure my safety.</li>
                                        </ul>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Attachments:</h3>
                                        <p class="mt-4 text-gray-600">[Provide screenshots of threats/messages if available]</p>
                                        <p class="mt-6 text-gray-600">I request urgent intervention before the situation escalates further.</p>
                                        <div class="mt-8 pt-6 border-t border-gray-200">
                                            <p class="font-medium text-gray-600">Sincerely,</p>
                                            <p>[Your Name]</p>
                                            <p>[Student ID]</p>
                                            <p>[Department Name]</p>
                                            <p>[Email ID]</p>
                                            <p>[Phone Number (Optional)]</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;
                        case 'Complaint Regarding Stalking Incident':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Stalking Incident</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>[University Authority Name]</p>
                                        <p>[University Name]</p>
                                        <p>[Address]</p>
                                        <p class="mt-4">Subject: Complaint Regarding Stalking Incident on [Date]</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], am filing this complaint regarding a stalking incident that occurred on [Date] at [Location] within the university premises.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Details:</h3>
                                        <p>Type of Incident: Stalking</p>
                                        <p>Date & Time: [Date] at [Time]</p>
                                        <p>Location: [Specific location]</p>
                                        <p>Perpetrator (if known): [Optional]</p>
                                        <p>Witnesses (if any): [Optional]</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Description:</h3>
                                        <p class="mt-4 text-gray-600">[Provide a brief but clear account of what happened, including how you noticed the stalking, any repeated behavior, and how it made you feel.]</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Requested Action:</h3>
                                        <p class="mt-4 text-gray-600">I urge the university to take immediate action as per the anti-harassment policies, including:</p>
                                        <ul class="list-disc pl-6 mt-2 text-gray-600">
                                            <li>Investigation of the incident (CCTV review, witness statements)</li>
                                            <li>Strengthening security in the concerned area</li>
                                            <li>Taking preventive measures to ensure student safety</li>
                                        </ul>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Attachments (if any):</h3>
                                        <p class="mt-4 text-gray-600">[Relevant screenshots, videos, or any supporting evidence.]</p>
                                        <p class="mt-6 text-gray-600">I request a prompt response and appropriate action to address this serious concern.</p>
                                        <p class="mt-8">Sincerely,</p>
                                        <p>[Your Name / Anonymous]</p>
                                        <p>[Your Contact Information (if comfortable sharing)]</p>
                                        <p>[Department Name, University Name]</p>
                                    </div>
                                </div>
                            `;
                            break;
                        case 'Complaint Regarding Offensive Comments or Remarks':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Offensive Comments or Remarks</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>The Anti-Ragging Cell,</p>
                                        <p>[University Name],</p>
                                        <p>[Address]</p>
                                        <p class="mt-4">Subject: Complaint Regarding Inappropriate Behavior by a Male Student</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], am writing to report an incident involving inappropriate behavior by a male student, [Name if known], on [Date] at [Location]. The male student was [describe the inappropriate behavior, e.g., following, making unsolicited comments, etc.], which made me feel uncomfortable and unsafe on campus.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Details:</h3>
                                        <p>Type of Incident: Inappropriate Behavior / Ragging</p>
                                        <p>Incident Description: [Provide a detailed account of the behavior, e.g., harassment, derogatory comments]</p>
                                        <p>Perpetrator: [Name of the student if known]</p>
                                        <p>Location: [Location of the incident on campus]</p>
                                        <p>Time of Incident: [Time of incident]</p>
                                        <p>Witnesses (if any): [Optional]</p>
                                        <p class="mt-4">I kindly request the Anti-Ragging Cell to take immediate action according to university regulations and ensure that this student's actions are addressed as per the law. I have attached any available evidence to substantiate my complaint.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Supporting Documents:</h3>
                                        <p>[List of documents or evidence, if any]</p>
                                        <p class="mt-4">Thank you for your prompt attention to this matter. I hope to receive a response at the earliest.</p>
                                        <div class="mt-8 pt-6 border-t border-gray-200">
                                        <p class="font-medium text-gray-600">Sincerely,</p>
                                        <p>[Your Name / Anonymous]</p>
                                        <p>[Student ID and Department]</p>
                                        <div class="sticky bottom-0 bg-white border-t p-4 mt-6">
                                        <button onclick="copyApplication()" class="w-full bg-[#D12E79] text-white px-6 py-3 rounded-lg hover:bg-[#AB1E5C] transition-colors flex items-center justify-center space-x-2">
                                            <i class="fas fa-copy"></i>
                                            <span>Copy to Clipboard</span>
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            `;
                            break;
                        case 'Complaint Regarding Offensive Comments or Remarks':
                            templateHTML = `
                                <h2 class="text-2xl font-bold mb-6 text-[#D12E79]">Complaint Regarding Offensive Behavior by a Male Student on Campus</h2>
                                <div class="space-y-6">
                                    <div class="flex-1 overflow-y-auto p-6 space-y-6 text-gray-700 leading-relaxed">
                                        <p>To,</p>
                                        <p>The Anti-Ragging Cell / Disciplinary Committee,</p>
                                        <p>[University Name],</p>
                                        <p>[University Address]</p>
                                        <p class="mt-4">Subject: Formal Complaint Regarding Offensive Behavior by a Male Student</p>
                                        <p class="mt-4">Respected Sir/Madam,</p>
                                        <p class="mt-4 text-gray-600">I, [Your Name / Anonymous], a student of [Department Name], am writing to formally report an incident of offensive and inappropriate behavior by a male student, [Offender’s Name (if known)], that took place on [Date] at [Location] within the university premises.</p>
                                        <p class="mt-4 text-gray-600">This incident has left me feeling unsafe and uncomfortable, and I strongly believe that immediate disciplinary action is necessary to ensure that such behavior is not repeated, either against me or any other female student on campus.</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Details of the Incident:</h3>
                                        <p>Type of Incident: Offensive Behavior / Harassment / Misconduct</p>
                                        <p>Incident Date: [DD/MM/YYYY]</p>
                                        <p>Time of Incident: [HH:MM AM/PM]</p>
                                        <p>Location: [Specify location]</p>
                                        <p>Perpetrator’s Name (if known): [Student’s Name]</p>
                                        <p>Student’s Department and Year (if known): [Department Name, Year of Study]</p>
                                        <h3 class="text-lg font-semibold text-[#AB1E5C] mt-6">Incident Description:</h3>
                                        <p class="mt-4 text-gray-600">On [Date], at approximately [Time], I was [mention activity] when I encountered [Offender’s Name]. Without any provocation, he [describe behavior details].</p>
                                        <p class="mt-4 text-gray-600">Despite my clear discomfort and efforts to ignore him, he continued to [describe persistent actions].</p>
                                    </div>
                                </div>
                            `;
                    }

                    modalContent.innerHTML = templateHTML;
                    document.getElementById('templateModal').classList.remove('hidden');
                    document.getElementById('templateModal').classList.add('flex');
                });
            });


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

        // Category filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('categoryFilter').addEventListener('change', function() {
                const selectedCategory = this.value;
                document.querySelectorAll('[data-category]').forEach(card => {
                    const cardCategory = card.dataset.category;
                    card.style.display = (selectedCategory === 'all' || cardCategory === selectedCategory)
                        ? ''
                        : 'none';
                });
            });
        });

        function copyApplication() {
            const modalContent = document.querySelector('#templateModal .bg-white').innerText;
            navigator.clipboard.writeText(modalContent).then(() => {
                alert('Application copied to clipboard!');
                closeModal();
            });
        }

        function showModal() {
            document.getElementById('templateModal').classList.remove('hidden');
            document.getElementById('templateModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('templateModal').classList.add('hidden');
            document.getElementById('templateModal').classList.remove('flex');
        }

        function useTemplate() {
            // Add template usage logic here
            closeModal();
        }
    </script>
</body>
</html>

<style>
        .border-gradient {
            border-bottom: 3px solid transparent;
            border-image: linear-gradient(90deg, #D12E79 0%, #AB1E5C 100%);
            border-image-slice: 1;
        }
        .fa-xmark {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</html>
