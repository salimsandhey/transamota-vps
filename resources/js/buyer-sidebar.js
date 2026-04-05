// JavaScript for collapsible buyer sidebar functionality

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const toggleIcon = document.getElementById('toggle-icon');
    const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const logoText = document.getElementById('logo-text');
    const userInfo = document.getElementById('user-info');
    const mainMenuLabel = document.getElementById('main-menu-label');
    const savedLabel = document.getElementById('saved-label');
    const otherMenuLabel = document.getElementById('other-menu-label');
    
    // Text elements to hide when collapsed
    const textElements = [
        document.getElementById('dashboard-text'),
        document.getElementById('products-text'),
        document.getElementById('orders-text'),
        document.getElementById('inquiries-text'),
        document.getElementById('messages-text'),
        document.getElementById('saved-products-text'),
        document.getElementById('reviews-text'),
        document.getElementById('settings-text'),
        document.getElementById('support-text'),
        document.getElementById('logout-text')
    ];

    // Check if we're on a page with sidebar elements
    if (!sidebar) {
        return; // Exit if no sidebar elements exist (e.g., on homepage)
    }

    // Check if sidebar should be collapsed by default (from localStorage)
    const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    // Initialize sidebar state
    if (window.innerWidth < 768) { // Mobile
        // On mobile, always start with sidebar hidden
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        if (mainContent) {
            mainContent.classList.remove('md:ml-64', 'md:ml-20', 'md:ml-0');
        }
    } else { // Desktop
        // On desktop, use localStorage setting
        if (isSidebarCollapsed) {
            collapseSidebar();
        } else {
            expandSidebar();
        }
    }

    // Desktop toggle button
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            if (sidebar.classList.contains('w-64')) {
                collapseSidebar();
                localStorage.setItem('sidebarCollapsed', 'true');
            } else {
                expandSidebar();
                localStorage.setItem('sidebarCollapsed', 'false');
            }
        });
    }

    // Mobile toggle button (now in header)
    if (mobileSidebarToggle) {
        mobileSidebarToggle.addEventListener('click', function() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0', 'mobile-open');
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('hidden');
            }
            document.body.classList.add('mobile-sidebar-open');
        });
    }

    // Overlay click to close sidebar on mobile
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('translate-x-0', 'mobile-open');
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('mobile-sidebar-open');
        });
    }

    // Function to collapse sidebar
    function collapseSidebar() {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        
        // Remove any margin classes if they exist
        if (mainContent) {
            mainContent.classList.remove('md:ml-0', 'md:ml-20', 'md:ml-64');
        }
        
        // Hide text elements
        textElements.forEach(element => {
            if (element) element.classList.add('hidden');
        });
        
        // Hide labels and user info
        if (logoText) logoText.classList.add('hidden');
        if (userInfo) userInfo.classList.add('hidden');
        if (mainMenuLabel) mainMenuLabel.classList.add('hidden');
        if (savedLabel) savedLabel.classList.add('hidden');
        if (otherMenuLabel) otherMenuLabel.classList.add('hidden');
        
        // Rotate toggle icon
        if (toggleIcon) {
            toggleIcon.style.transform = 'rotate(180deg)';
        }
    }

    // Function to expand sidebar
    function expandSidebar() {
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-64');
        
        // Remove any margin classes if they exist
        if (mainContent) {
            mainContent.classList.remove('md:ml-0', 'md:ml-20', 'md:ml-64');
        }
        
        // Show text elements
        textElements.forEach(element => {
            if (element) element.classList.remove('hidden');
        });
        
        // Show labels and user info
        if (logoText) logoText.classList.remove('hidden');
        if (userInfo) userInfo.classList.remove('hidden');
        if (mainMenuLabel) mainMenuLabel.classList.remove('hidden');
        if (savedLabel) savedLabel.classList.remove('hidden');
        if (otherMenuLabel) otherMenuLabel.classList.remove('hidden');
        
        // Reset toggle icon
        if (toggleIcon) {
            toggleIcon.style.transform = 'rotate(0deg)';
        }
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth < 768) { // Mobile
            // On mobile, always ensure sidebar is properly hidden when not open
            if (!sidebar.classList.contains('mobile-open')) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }
            if (mainContent) {
                mainContent.classList.remove('md:ml-64', 'md:ml-20', 'md:ml-0');
            }
        } else { // Desktop
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            // On desktop, use localStorage setting
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                collapseSidebar();
            } else {
                expandSidebar();
            }
            // Remove mobile-specific classes
            sidebar.classList.remove('mobile-open');
            document.body.classList.remove('mobile-sidebar-open');
            if (sidebarOverlay) {
                sidebarOverlay.classList.add('hidden');
            }
        }
    });

    // Initialize on load
    if (window.innerWidth < 768) {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        if (mainContent) {
            mainContent.classList.remove('md:ml-64', 'md:ml-20', 'md:ml-0');
        }
    }
});