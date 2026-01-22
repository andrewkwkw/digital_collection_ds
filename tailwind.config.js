import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#f4f7f4',
                    100: '#e5ede5',
                    200: '#cbdccb', // Tambahan untuk variasi hover
                    500: '#5F8E5F', // Warna Utama Anda
                    600: '#4d744d',
                    700: '#3e5d3e',
                }
            }, // Kurung tutup untuk colors
        }, // Kurung tutup untuk extend
    }, // Kurung tutup untuk theme

    plugins: [forms],
};