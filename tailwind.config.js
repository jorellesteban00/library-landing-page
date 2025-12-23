import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    500: '#6366f1', // Indigo-500
                    600: '#4f46e5', // Indigo-600
                    700: '#4338ca', // Indigo-700
                    900: '#312e81', // Indigo-900
                },
                accent: {
                    DEFAULT: '#f43f5e', // Rose-500
                    hover: '#e11d48',   // Rose-600
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
