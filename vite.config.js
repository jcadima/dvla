import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

console.log('Environment Variables:', process.env); // debug variables
const isProduction = process.env.NODE_ENV === 'production';
const baseURL = isProduction ? 'https://dvla.jcadima.dev' : 'http://localhost:8084';
console.log('baseURL' , baseURL);

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],


    base: baseURL,

    server: {
        proxy: {
            '^/pages/.*': {
                target: baseURL,
            }
        }
    },

    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `$base-url: "${baseURL}";` // Pass base URL to SCSS
            }
        }
    }

});
