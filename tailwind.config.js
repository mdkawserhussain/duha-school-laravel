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
                // Zaitoon Academy Brand Colors (100% Exact Match from beta.zaitoonacademy.com)
                za: {
                    // Primary Green Shades (Exact from site analysis)
                    'green-dark': '#0B5D1E',      // Dark green for top bar/footer (RGB: 11, 93, 30)
                    'green-primary': '#16A34A',  // Main green for buttons (RGB: 22, 163, 74)
                    'green-light': '#F0FDF4',    // Light green backgrounds (RGB: 240, 253, 244)
                    'green-pastel': '#DCFCE7',   // Pastel green for sections (RGB: 220, 252, 231)
                    'green-50': '#F0FDF4',
                    'green-100': '#DCFCE7',
                    'green-200': '#BBF7D0',
                    'green-300': '#86EFAC',
                    'green-400': '#4ADE80',
                    'green-500': '#22C55E',
                    'green-600': '#16A34A',      // Primary
                    'green-700': '#15803D',
                    'green-800': '#166534',
                    'green-900': '#14532D',
                    // Yellow Accent Shades (Exact Match)
                    'yellow-accent': '#FBBF24',  // Bright yellow for CTA buttons (RGB: 251, 191, 36)
                    'yellow-light': '#FEF3C7',
                    'yellow-dark': '#F59E0B',    // Darker yellow for hover
                    'yellow-50': '#FFFBEB',
                    'yellow-100': '#FEF3C7',
                    'yellow-200': '#FDE68A',
                    'yellow-300': '#FCD34D',
                    'yellow-400': '#FBBF24',     // Primary yellow
                    'yellow-500': '#F59E0B',
                    'yellow-600': '#D97706',
                    'yellow-700': '#B45309',
                    'yellow-800': '#92400E',
                    'yellow-900': '#78350F',
                    // Orange Accent (for decorative elements)
                    'orange': '#FB923C',         // RGB: 251, 146, 60
                    // Blue (for navigation arrows)
                    'blue': '#3B82F6',           // RGB: 59, 130, 246
                },
                // AISD Brand Colors - Matching CSS variables exactly
                aisd: {
                    midnight: '#0F224C',      // rgb(15, 34, 76) - Deep blue
                    ocean: '#0C1B3D',         // rgb(12, 27, 61) - Darker blue
                    cobalt: '#192D5A',        // rgb(25, 45, 90) - Medium blue
                    sky: '#6EC1F5',
                    gold: '#FCD34D',          // rgb(252, 211, 77) - Gold (matching CSS)
                    cream: '#F8F5EB',
                    slate: '#7F8DB2',
                },
                // Brand/Indigo colors for buttons and gradients
                brand: {
                    50: '#f0f4ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',           // Primary indigo
                    700: '#4338ca',           // Hover indigo
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
                },
                // Accent/Orange colors
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
                // Ink/Gray colors for text
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
                // Additional colors from homepage
                gray: {
                    50: '#F9FAFB',
                    100: '#F3F4F6',
                    200: '#E5E7EB',
                    300: '#D1D5DB',
                    400: '#9CA3AF',
                    500: '#6B7280',
                    600: '#4B5563',
                    700: '#374151',
                    800: '#1F2937',
                    900: '#111827',
                },
                slate: {
                    50: '#F8FAFC',
                    100: '#F1F5F9',
                    200: '#E2E8F0',
                    300: '#CBD5E1',
                    400: '#94A3B8',
                    500: '#64748B',
                    600: '#475569',
                    700: '#334155',
                    800: '#1E293B',
                    900: '#0F172A',
                },
                indigo: {
                    50: '#EEF2FF',
                    100: '#E0E7FF',
                    200: '#C7D2FE',
                    300: '#A5B4FC',
                    400: '#818CF8',
                    500: '#6366F1',
                    600: '#4F46E5',           // Primary
                    700: '#4338CA',           // Hover
                    800: '#3730A3',
                    900: '#312E81',
                },
                violet: {
                    500: '#7C3AED',
                    600: '#6D28D9',
                },
                pink: {
                    500: '#EC4899',
                },
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', '"Inter"', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', 'sans-serif'],
                serif: ['"Playfair Display"', '"Merriweather"', 'Georgia', 'serif'],
                display: ['"Playfair Display"', 'serif'],
                mono: ['"JetBrains Mono"', '"Fira Code"', 'Consolas', 'Monaco', 'monospace'],
            },
            fontSize: {
                xs: ['0.75rem', { lineHeight: '1rem' }],
                sm: ['0.875rem', { lineHeight: '1.25rem' }],
                base: ['1rem', { lineHeight: '1.5rem' }],
                lg: ['1.125rem', { lineHeight: '1.75rem' }],
                xl: ['1.25rem', { lineHeight: '1.75rem' }],
                '2xl': ['1.5rem', { lineHeight: '2rem' }],
                '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
                '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
                '5xl': ['3rem', { lineHeight: '1.2' }],
                '6xl': ['3.75rem', { lineHeight: '1.2' }],
            },
            spacing: {
                '18': '4.5rem',
                '22': '5.5rem',
                '26': '6.5rem',
                '30': '7.5rem',
                '34': '8.5rem',
                '88': '22rem',
                '100': '25rem',
                '112': '28rem',
                '128': '32rem',
            },
            borderRadius: {
                'none': '0',
                'sm': '0.125rem',
                DEFAULT: '0.25rem',
                'md': '0.375rem',
                'lg': '0.5rem',
                'xl': '0.75rem',
                '2xl': '1rem',
                '3xl': '1.5rem',
                'full': '9999px',
            },
            boxShadow: {
                'soft': '0 25px 50px -12px rgba(13, 29, 77, 0.18)',
                'card': '0 18px 40px -15px rgba(9, 20, 45, 0.2)',
                'modern': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)',
                'modern-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)',
                'primary': '0 10px 15px -3px rgba(79, 70, 229, 0.3)',
                'primary-hover': '0 20px 25px -5px rgba(79, 70, 229, 0.4)',
                'card-hover': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                'navbar': '0 4px 20px -2px rgba(0, 0, 0, 0.1), 0 2px 8px -2px rgba(0, 0, 0, 0.06)',
                'dropdown': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                'search': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                // Zaitoon-specific shadows
                'za-green': '0 10px 30px rgba(26, 94, 74, 0.15)',
                'za-green-lg': '0 20px 40px rgba(26, 94, 74, 0.2)',
                'za-yellow': '0 10px 30px rgba(251, 191, 36, 0.15)',
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(135deg, #0d1d4d 0%, #1a379e 40%, #365de0 100%)',
                'section-split': 'linear-gradient(180deg, rgba(240, 244, 255, 0) 0%, rgba(240, 244, 255, 1) 100%)',
                'aisd-wave': 'radial-gradient(circle at top, rgba(110, 193, 245, 0.25), transparent 65%), linear-gradient(135deg, #0C1B3D 0%, #173B7A 60%, #0F224C 100%)',
                'aisd-stripes': 'linear-gradient(120deg, rgba(244, 196, 48, 0.12) 0%, rgba(12, 27, 61, 0.12) 100%)',
                'aisd-parallax': 'linear-gradient(120deg, rgba(12, 27, 61, 0.85), rgba(15, 34, 76, 0.7))',
                'button-primary': 'linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%)',
                'button-primary-hover': 'linear-gradient(135deg, #4338CA 0%, #6D28D9 100%)',
                'text-gradient': 'linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%)',
                'hero-panel': 'linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%)',
                'gradient-indigo-violet': 'linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%)',
                'gradient-violet-pink': 'linear-gradient(135deg, #7C3AED 0%, #EC4899 100%)',
                'gradient-pink-amber': 'linear-gradient(135deg, #EC4899 0%, #F59E0B 100%)',
                'gradient-amber-emerald': 'linear-gradient(135deg, #F59E0B 0%, #10B981 100%)',
                // Zaitoon-specific gradients
                'za-green-gradient': 'linear-gradient(135deg, #1a5e4a 0%, #0f3d30 100%)',
                'za-green-soft': 'linear-gradient(135deg, #e8f5f1 0%, #d1fae5 100%)',
                'za-hero': 'linear-gradient(135deg, rgba(15, 61, 48, 0.9) 0%, rgba(26, 94, 74, 0.85) 100%)',
            },
            animation: {
                'gradient-shift': 'gradientShift 8s ease infinite',
                'icon-bounce': 'iconBounce 0.6s ease-in-out',
                'marquee-scroll': 'marquee-scroll 20s linear infinite',
            },
            keyframes: {
                gradientShift: {
                    '0%': { backgroundPosition: '0% 50%' },
                    '50%': { backgroundPosition: '100% 50%' },
                    '100%': { backgroundPosition: '0% 50%' },
                },
                iconBounce: {
                    '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
                    '50%': { transform: 'translateY(-8px) rotate(12deg)' },
                },
                'marquee-scroll': {
                    '0%': { transform: 'translateX(100%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
            },
            transitionDuration: {
                '400': '400ms',
                '600': '600ms',
            },
            transitionTimingFunction: {
                'bounce-in': 'cubic-bezier(0.68, -0.55, 0.265, 1.55)',
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1.5rem',
                    sm: '1.5rem',
                    md: '2rem',
                    lg: '2rem',
                    xl: '2.5rem',
                    '2xl': '3rem',
                },
            },
        },
    },
};
