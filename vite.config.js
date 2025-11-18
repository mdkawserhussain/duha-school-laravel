import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/fallback.css',
                'resources/js/app.js',
                'resources/js/homepage.js'
            ],
            // Disable automatic page refresh in development to prevent unexpected reloads
            // HMR (Hot Module Replacement) will still work for CSS/JS updates
            // Set to false to disable automatic refresh when Blade templates change
            refresh: false,
        }),
    ],
    server: {
        hmr: {
            overlay: false,
            // Disable HMR full page reload - only update changed modules
            clientPort: 5173,
        }
    }
});
