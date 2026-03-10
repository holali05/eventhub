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
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                outfit: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Primary brand color: warm coral/crimson (great for event/entertainment sites)
                coral: {
                    50: '#fff5f3',
                    100: '#ffe8e3',
                    200: '#ffd0c7',
                    300: '#ffac9c',
                    400: '#ff7c62',
                    500: '#ff5438',
                    600: '#ed3314',
                    700: '#c7260d',
                    800: '#a4220f',
                    900: '#882314',
                    950: '#490d05',
                },
                // Keep iris as alias so existing blade refs still compile (maps to coral)
                iris: {
                    50: '#fff5f3',
                    100: '#ffe8e3',
                    200: '#ffd0c7',
                    300: '#ffac9c',
                    400: '#ff7c62',
                    500: '#ff5438',
                    600: '#ed3314',
                    700: '#c7260d',
                    800: '#a4220f',
                    900: '#882314',
                    950: '#490d05',
                },
            },
            borderRadius: {
                '3xl': '1.5rem',
                '4xl': '2rem',
            },
            boxShadow: {
                'soft': '0 10px 40px -10px rgba(237, 51, 20, 0.08)',
                'iris': '0 10px 40px -10px rgba(237, 51, 20, 0.22)',
                'coral': '0 10px 40px -10px rgba(237, 51, 20, 0.22)',
            }
        },
    },

    plugins: [forms],
};
