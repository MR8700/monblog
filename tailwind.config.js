import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import aspectRatio from '@tailwindcss/aspect-ratio';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],

  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#0066cc', // Bleu principal
          light: '#3385ff',
          dark: '#004999',
          50: '#f0f7ff',
          100: '#e0eeff',
          200: '#c1e0ff',
          300: '#a0cfff',
          400: '#80bdff',
          500: '#0066cc',
          600: '#0052a3',
          700: '#003d7a',
          800: '#002851',
          900: '#001328',
        },
        secondary: {
          DEFAULT: '#ff6b35', // Orange accent
          light: '#ff8c61',
          dark: '#cc5629',
        },
        accent: {
          DEFAULT: '#06b6d4', // Cyan
          light: '#22d3ee',
          dark: '#0891b2',
        },
        success: {
          DEFAULT: '#10b981',
          light: '#6ee7b7',
          dark: '#047857',
        },
        danger: {
          DEFAULT: '#ef4444',
          light: '#f87171',
          dark: '#dc2626',
        },
        warning: {
          DEFAULT: '#f59e0b',
          light: '#fcd34d',
          dark: '#d97706',
        },
        info: {
          DEFAULT: '#3b82f6',
          light: '#93c5fd',
          dark: '#1d4ed8',
        },
        ink: '#0f172a',
        sand: '#f8fafc',
        dusk: '#312e81',
        slateSoft: '#e2e8f0',
      },

      fontFamily: {
        sans: ['Source Sans 3', ...defaultTheme.fontFamily.sans],
        heading: ['Space Grotesk', 'Source Sans 3', 'sans-serif'],
        display: ['Playfair Display', 'Space Grotesk', 'serif'],
      },

      container: {
        center: true,
        padding: '1.5rem',
      },

      boxShadow: {
        soft: '0 4px 20px rgba(0,0,0,0.05)',
        deep: '0 8px 24px rgba(0,0,0,0.1)',
        glow: '0 20px 45px rgba(15,23,42,0.18)',
      },

      borderRadius: {
        '4xl': '2rem',
      },
    },
  },

  plugins: [
    forms,
    typography,
    aspectRatio,
  ],
};
