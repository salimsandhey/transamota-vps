import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    // Add base configuration for production
    base: process.env.NODE_ENV === 'production'
        ? '/build/'
        : '/',
    server: {
        host: '0.0.0.0', // Allow connections from any IP
        port: 5173,
        strictPort: true,
        cors: true, // Enable CORS
        // Configure HMR to use the correct host for external access
        hmr: {
            host: '192.168.1.4',
            port: 5173,
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/seller-sidebar.css',
                'resources/css/buyer-sidebar.css',
                'resources/js/app.js',
                'resources/js/seller-sidebar.js',
                'resources/js/buyer-sidebar.js',
                'resources/js/header.js'
            ],
            refresh: true,
            valetTls: false,
            detectTls: false,
            hotFile: 'public/hot',
            buildDirectory: 'build',
            ssrOutputDirectory: 'bootstrap/ssr',
        }),
        tailwindcss(),
    ],
    optimizeDeps: {
        include: ['axios', 'laravel-echo', 'pusher-js']
    }
});