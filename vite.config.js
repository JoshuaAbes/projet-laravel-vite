import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';  // Ajoutez cette ligne

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({  // Ajoutez cette configuration
            template: {
                transformAssetUrls: {
                    // Les balises et attributs qui seront traités
                    base: null,
                    includeAbsolute: false,
                }
            }
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',  // Ajoutez cette alias pour les imports '@/...'
        },
    },
});
