// JavaScript for header functionality (user menu dropdown, mobile menu toggle, search)

console.log('Header.js loading...');

document.addEventListener('DOMContentLoaded', function() {
    console.log('Header.js DOMContentLoaded event fired');
    
    // User menu dropdown toggle
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuButton && userMenu) {
        console.log('User menu elements found');
        
        // Remove any existing event listeners to prevent duplicates
        userMenuButton.removeEventListener('click', handleUserMenuClick);
        
        function handleUserMenuClick(e) {
            e.stopPropagation();
            console.log('User menu button clicked');
            userMenu.classList.toggle('hidden');
        }
        
        userMenuButton.addEventListener('click', handleUserMenuClick);
        
        // Close dropdown when clicking outside
        document.removeEventListener('click', handleDocumentClick);
        
        function handleDocumentClick(e) {
            if (userMenu && !userMenu.classList.contains('hidden') && 
                !userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                console.log('Clicked outside user menu, hiding it');
                userMenu.classList.add('hidden');
            }
        }
        
        document.addEventListener('click', handleDocumentClick);
    } else {
        console.log('User menu elements not found');
    }
    
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileNavButton = document.getElementById('mobile-nav-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if ((mobileMenuButton || mobileNavButton) && mobileMenu) {
        console.log('Mobile menu elements found');
        
        // Remove any existing event listeners to prevent duplicates
        if (mobileMenuButton) {
            mobileMenuButton.removeEventListener('click', handleMobileMenuClick);
        }
        
        if (mobileNavButton) {
            mobileNavButton.removeEventListener('click', handleMobileMenuClick);
        }
        
        function handleMobileMenuClick(e) {
            e.stopPropagation();
            console.log('Mobile menu button clicked');
            mobileMenu.classList.toggle('hidden');
        }
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', handleMobileMenuClick);
        }
        
        if (mobileNavButton) {
            mobileNavButton.addEventListener('click', handleMobileMenuClick);
        }
        
        // Close mobile menu when clicking outside
        document.removeEventListener('click', handleMobileDocumentClick);
        
        function handleMobileDocumentClick(e) {
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                const isClickInside = (mobileMenuButton && mobileMenuButton.contains(e.target)) || 
                                     (mobileNavButton && mobileNavButton.contains(e.target)) || 
                                     mobileMenu.contains(e.target);
                
                if (!isClickInside) {
                    console.log('Clicked outside mobile menu, hiding it');
                    mobileMenu.classList.add('hidden');
                }
            }
        }
        
        document.addEventListener('click', handleMobileDocumentClick);
    } else {
        console.log('Mobile menu elements not found');
    }
    
    // Mobile additional menu toggle (for seller/buyer specific menus)
    const mobileAdditionalMenuButton = document.getElementById('mobile-additional-menu-button');
    const mobileAdditionalMenu = document.getElementById('mobile-additional-menu');
    
    if (mobileAdditionalMenuButton && mobileAdditionalMenu) {
        console.log('Mobile additional menu elements found');
        
        // Remove any existing event listeners to prevent duplicates
        mobileAdditionalMenuButton.removeEventListener('click', handleAdditionalMenuClick);
        
        function handleAdditionalMenuClick(e) {
            e.stopPropagation();
            console.log('Mobile additional menu button clicked');
            mobileAdditionalMenu.classList.toggle('hidden');
        }
        
        mobileAdditionalMenuButton.addEventListener('click', handleAdditionalMenuClick);
        
        // Close additional menu when clicking outside
        document.removeEventListener('click', handleAdditionalDocumentClick);
        
        function handleAdditionalDocumentClick(e) {
            if (mobileAdditionalMenu && !mobileAdditionalMenu.classList.contains('hidden') &&
                !mobileAdditionalMenuButton.contains(e.target) && !mobileAdditionalMenu.contains(e.target)) {
                console.log('Clicked outside additional menu, hiding it');
                mobileAdditionalMenu.classList.add('hidden');
            }
        }
        
        document.addEventListener('click', handleAdditionalDocumentClick);
    } else {
        console.log('Mobile additional menu elements not found');
    }
    
    // Search functionality for desktop and mobile search bars
    initializeSearchFunctionality();
    
    // Scroll category navigation to show active category
    scrollToActiveCategory();
});

function initializeSearchFunctionality() {
    // Desktop search bars
    const desktopSearchInputs = document.querySelectorAll('.hidden.md\\:block input[type="text"][placeholder*="Search"]');
    const desktopSearchButtons = document.querySelectorAll('.hidden.md\\:block button[title*="search"], .hidden.md\\:block button[title*="Search"]');
    
    // Mobile search bars
    const mobileSearchInputs = document.querySelectorAll('.md\\:hidden input[type="text"][placeholder*="Search"]');
    const mobileSearchButtons = document.querySelectorAll('.md\\:hidden button[title*="search"], .md\\:hidden button[title*="Search"]');
    
    console.log('Search elements found:', {
        desktopInputs: desktopSearchInputs.length,
        desktopButtons: desktopSearchButtons.length,
        mobileInputs: mobileSearchInputs.length,
        mobileButtons: mobileSearchButtons.length
    });
    
    // Handle desktop search
    desktopSearchInputs.forEach((input, index) => {
        // Add enter key support
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch(this.value.trim());
            }
        });
        
        // Add search button click if it exists
        if (desktopSearchButtons[index]) {
            desktopSearchButtons[index].addEventListener('click', function() {
                const searchInput = this.closest('.relative').querySelector('input[type="text"]');
                if (searchInput) {
                    performSearch(searchInput.value.trim());
                }
            });
        }
    });
    
    // Handle mobile search
    mobileSearchInputs.forEach((input, index) => {
        // Add enter key support
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch(this.value.trim());
            }
        });
        
        // Add search button click if it exists
        if (mobileSearchButtons[index]) {
            mobileSearchButtons[index].addEventListener('click', function() {
                const searchInput = this.closest('.relative').querySelector('input[type="text"]');
                if (searchInput) {
                    performSearch(searchInput.value.trim());
                }
            });
        }
    });
}

function performSearch(searchTerm) {
    if (searchTerm.length > 0) {
        // Redirect to products browse page with search term
        const searchUrl = `/products/browse?search=${encodeURIComponent(searchTerm)}`;
        window.location.href = searchUrl;
    }
}

// Scroll category navigation to show active category
function scrollToActiveCategory() {
    // Find the category navigation container
    const categoryNav = document.querySelector('.hidden.md\\:flex.overflow-x-auto.py-3');
    
    if (categoryNav) {
        // Find the active category link
        const activeCategory = categoryNav.querySelector('a.text-blue-600.bg-blue-50.font-semibold');
        
        if (activeCategory) {
            // Calculate the position to scroll to (center the active category)
            const containerRect = categoryNav.getBoundingClientRect();
            const activeRect = activeCategory.getBoundingClientRect();
            
            // Calculate the scroll position to center the active category
            const scrollPosition = activeCategory.offsetLeft - (containerRect.width / 2) + (activeRect.width / 2);
            
            // Scroll to the calculated position
            categoryNav.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }
    }
}

// Also handle clicks on the document for cases where DOMContentLoaded might not catch everything
document.addEventListener('click', function(e) {
    // User menu
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenu && !userMenu.classList.contains('hidden') && userMenuButton && 
        !userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
        userMenu.classList.add('hidden');
    }
    
    // Mobile menu
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileNavButton = document.getElementById('mobile-nav-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenu && !mobileMenu.classList.contains('hidden') && 
        !(mobileMenuButton && mobileMenuButton.contains(e.target)) && 
        !(mobileNavButton && mobileNavButton.contains(e.target)) && 
        !mobileMenu.contains(e.target)) {
        mobileMenu.classList.add('hidden');
    }
    
    // Mobile additional menu
    const mobileAdditionalMenuButton = document.getElementById('mobile-additional-menu-button');
    const mobileAdditionalMenu = document.getElementById('mobile-additional-menu');
    
    if (mobileAdditionalMenu && !mobileAdditionalMenu.classList.contains('hidden') &&
        mobileAdditionalMenuButton && !mobileAdditionalMenuButton.contains(e.target) && 
        !mobileAdditionalMenu.contains(e.target)) {
        mobileAdditionalMenu.classList.add('hidden');
    }
});