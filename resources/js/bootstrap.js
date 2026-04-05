import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Log Pusher configuration for debugging
console.log('Pusher config:', {
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    host: import.meta.env.VITE_PUSHER_HOST,
    port: import.meta.env.VITE_PUSHER_PORT,
    scheme: import.meta.env.VITE_PUSHER_SCHEME
});

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    // Add these for better debugging
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    }
});

// Add connection event handlers for debugging
if (window.Echo && window.Echo.connector && window.Echo.connector.pusher) {
    window.Echo.connector.pusher.connection.bind('connected', function() {
        console.log('Pusher connected successfully');
    });
    
    window.Echo.connector.pusher.connection.bind('disconnected', function() {
        console.log('Pusher disconnected');
    });
    
    window.Echo.connector.pusher.connection.bind('error', function(error) {
        console.error('Pusher connection error:', error);
    });
    
    window.Echo.connector.pusher.connection.bind('state_change', function(states) {
        console.log('Pusher connection state changed:', states);
    });
}