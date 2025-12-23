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
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    500: '#10b981', // Emerald-500
                    600: '#059669', // Emerald-600
                    700: '#047857', // Emerald-700
                    900: '#064e3b', // Emerald-900
                },
                accent: {
                    DEFAULT: '#84cc16', // Lime-500
                    hover: '#65a30d',   // Lime-600
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
