/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/**/*.php',
    ],

    theme: {
        extend: {
            colors: {
                aisd: {
                    midnight: '#0C1B3D',
                    ocean: '#173B7A',
                    cobalt: '#0F224C',
                    sky: '#6EC1F5',
                    gold: '#F4C430',
                    cream: '#F8F5EB',
                    slate: '#7F8DB2',
                },
                brand: {
                    50: '#f0f4ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
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
                sans: ['"Plus Jakarta Sans"', '"Inter"', 'system-ui', 'sans-serif'],
                display: ['"Playfair Display"', 'serif'],
            },
            boxShadow: {
                soft: '0 25px 50px -12px rgba(13, 29, 77, 0.18)',
                card: '0 18px 40px -15px rgba(9, 20, 45, 0.2)',
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(135deg, #0d1d4d 0%, #1a379e 40%, #365de0 100%)',
                'section-split': 'linear-gradient(180deg, rgba(240, 244, 255, 0) 0%, rgba(240, 244, 255, 1) 100%)',
                'aisd-wave': 'radial-gradient(circle at top, rgba(110, 193, 245, 0.25), transparent 65%), linear-gradient(135deg, #0C1B3D 0%, #173B7A 60%, #0F224C 100%)',
                'aisd-stripes': 'linear-gradient(120deg, rgba(244, 196, 48, 0.12) 0%, rgba(12, 27, 61, 0.12) 100%)',
                'aisd-parallax': 'linear-gradient(120deg, rgba(12, 27, 61, 0.85), rgba(15, 34, 76, 0.7))',
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1.5rem',
                    lg: '2rem',
                    xl: '2.5rem',
                    '2xl': '3rem',
                },
            },
        },
    },
};
