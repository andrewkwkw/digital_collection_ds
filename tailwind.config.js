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
                    50:  '#f4f7f4', // Background sangat terang
                    100: '#e5ede5', // Background terang
                    200: '#cbdccb', // Border halus / Background Card
                    300: '#a3c4a3', // Border aktif / Disabled button
                    400: '#7fa97f', // Ikon sekunder
                    500: '#5F8E5F', // WARNA UTAMA (Sage Green)
                    600: '#4d744d', // Hover button utama
                    700: '#3e5d3e', // Text judul / Active state
                    800: '#324a32', // Background Dark Mode Card
                    900: '#283a28', // Navbar / Hero Section / Footer
                    950: '#151f15', // Background Dark Mode Body (Sangat Gelap)
                }
            }, 
        }, 
    }, 

    plugins: [forms],
};