import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/core.css',
                'resources/css/core-dark.css',
                'resources/css/theme-dark.css',
                'resources/css/theme-default.css',
                'resources/css/custom-style.css',
                'resources/js/app.js',
                'resources/js/helpers.js',
                'resources/js/menu.js',
                'resources/js/main.js',
                'resources/css/page-auth.css'
            ],
            refresh: true,
        }),
    ],
});
