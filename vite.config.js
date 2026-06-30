// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import { bunny } from 'laravel-vite-plugin/fonts';
// import tailwindcss from '@tailwindcss/vite';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//             fonts: [
//                 bunny('Instrument Sans', {
//                     weights: [400, 500, 600],
//                 }),
//             ],
//         }),
//         tailwindcss(),
//     ],
//     server: {
//         watch: {
//             ignored: ['**/storage/framework/views/**'],
//         },
//     },
// });

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // 1. Memanggil plugin Tailwind v4

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(), // 2. Mengaktifkan plugin di dalam Vite
    ],
    // server: {
    //     host: '0.0.0.0', // Mengizinkan akses dari luar
    //     port: 5173,
    //     hmr: {
    //         host: '10.42.64.93', // WAJIB: Paksa Vite menggunakan IP Laptop Anda, bukan localhost
    //     },
    // },
});