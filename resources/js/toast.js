// Toast notification utility for displaying flipkart-like notifications
class Toast {
    static show(message, type = 'success') {
        // Remove any existing toasts
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed top-4 right-4 z-[9999] px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out flex items-center max-w-md ${type === 'success' ? 'bg-blue-600' : 'bg-red-500'} text-white`;
        
        // Add icon based on type
        const icon = document.createElement('div');
        icon.className = 'mr-3 flex-shrink-0';
        icon.innerHTML = type === 'success' ? 
            `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>` :
            `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>`;
        
        // Add message
        const messageEl = document.createElement('div');
        messageEl.className = 'font-medium';
        messageEl.textContent = message;
        
        // Add close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'ml-4 flex-shrink-0';
        closeBtn.innerHTML = `
            <svg class="w-5 h-5 opacity-70 hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        `;
        closeBtn.onclick = () => toast.remove();
        
        // Assemble toast
        toast.appendChild(icon);
        toast.appendChild(messageEl);
        toast.appendChild(closeBtn);
        
        // Add to document
        document.body.appendChild(toast);
        
        // Trigger entrance animation
        setTimeout(() => {
            toast.style.transform = 'translateY(0)';
            toast.style.opacity = '1';
        }, 10);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.transform = 'translateY(-100%)';
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 3000);
    }
}

// Export for use in other modules
export default Toast;