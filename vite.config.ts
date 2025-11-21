import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    // server: {
    //     host: '0.0.0.0',   // allow connections from Docker/WSL
    //     port: 5173,        // match your exposed port
    //     hmr: {
    //         host: 'localhost', // ensures browser connects correctly
    //     },
    //     watch: {
    //         usePolling: true,  // fixes file change detection in WSL2/Docker
    //         interval: 100,     // polling interval in ms
    //     },
    // },
});
