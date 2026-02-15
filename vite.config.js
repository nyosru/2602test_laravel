import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';  // ← это должно работать с v6+

export default defineConfig({
    // css: {
    //     postcss: {
    //         plugins: [tailwindcss()],
    //     },
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

        vue(
            {
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }
        ),
    ],
    server: {
        host: true,
        hmr: {
            // host: 'lara2602.local',
            host: 'localhost',
        },
        watch: {
            usePolling: true,   // ← если изменения не ловит
        }
    }
});
