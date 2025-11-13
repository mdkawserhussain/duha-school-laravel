import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: '1.5rem',
                lg: '2rem',
                xl: '2.5rem',
                '2xl': '3rem',
            },
        },
        extend: {
            colors: {
                brand: {
                    50: '#f3f5ff',
                    100: '#e7ebfe',
                    200: '#c7d3fa',
                    300: '#9bb1f3',
                    400: '#6687ea',
                    500: '#365de0',
                    600: '#2548c6',
                    700: '#1a379e',
                    800: '#132a75',
                    900: '#0d1d4d',
                    950: '#081336',
                },
                accent: {
                    50: '#fff8eb',
                    100: '#fee8c5',
                    200: '#fed18a',
                    300: '#fdb64f',
                    400: '#fba52c',
                    500: '#f58f0d',
                    600: '#d77207',
                    700: '#b0560a',
                    800: '#8a410f',
                    900: '#6f3510',
                },
                ink: {
                    50: '#f7f8fb',
                    100: '#edeff6',
                    200: '#d7dce7',
                    300: '#b4bbcf',
                    400: '#8890af',
                    500: '#636c93',
                    600: '#474f74',
                    700: '#343b57',
                    800: '#222739',
                    900: '#131623',
                },
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Playfair Display"', 'serif'],
            },
            boxShadow: {
                soft: '0 25px 50px -12px rgba(13, 29, 77, 0.18)',
                card: '0 18px 40px -15px rgba(9, 20, 45, 0.2)',
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(135deg, #0d1d4d 0%, #1a379e 40%, #365de0 100%)',
                'section-split': 'linear-gradient(180deg, rgba(240, 244, 255, 0) 0%, rgba(240, 244, 255, 1) 100%)',
            },
        },
    },

    plugins: [forms],
};
