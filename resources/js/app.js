import './bootstrap';
import './header';
import './buyer-sidebar';
import Toast from './toast';

console.log('App.js loaded - buyer sidebar imported directly');

// Make Toast globally available
window.Toast = Toast;

// Conditionally load sidebar scripts based on the current page
document.addEventListener('DOMContentLoaded', function() {
    console.log('App.js loaded');
    console.log('Current URL:', window.location.href);
    
    const sidebar = document.querySelector('#sidebar');
    console.log('Sidebar element exists:', !!sidebar);
    
    if (sidebar) {
        // Check if we're on a seller dashboard page
        if (window.location.href.includes('/seller/')) {
            console.log('Loading seller sidebar');
            import('./seller-sidebar');
        }
        // Check if we're on a buyer dashboard page
        else if (window.location.href.includes('/buyer/')) {
            console.log('Loading buyer sidebar');
            import('./buyer-sidebar');
        } else {
            console.log('Sidebar found but no match for seller/buyer');
            // For debugging, let's load buyer sidebar on any page with sidebar that contains "buyer"
            if (window.location.href.includes('buyer')) {
                console.log('Forcing buyer sidebar load for debugging');
                import('./buyer-sidebar');
            }
        }
    } else {
        console.log('No sidebar element found on page');
    }
});