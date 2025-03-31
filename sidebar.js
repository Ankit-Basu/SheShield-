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

// Initialize sidebar when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new Sidebar();
});