import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/admin/normalize.css',  // дополнительные стили
                'resources/css/admin/styles.css',     // дополнительные стили
            ],
            refresh: true,
        }),
    ],
});
