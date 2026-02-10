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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                tajawal: ['Tajawal', 'sans-serif'],
            },
            colors: {
                primary: {
                    DEFAULT: '#040629', // Deep Navy from sidebar
                    light: '#0a0e45',
                    dark: '#02031a',
                },
                brand: {
                    DEFAULT: '#3b82f6', // Bright Blue from hover states
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                success: '#22c55e',
                warning: '#f97316',
                danger: '#ef4444',
            }
        },
    },

    plugins: [forms],
};
