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
          DEFAULT: '#0f172a',
          light: '#1e293b',
          dark: '#0b1220',
        },
        secondary: {
          DEFAULT: '#f97316',
          light: '#fb923c',
          dark: '#ea580c',
        },
        accent: {
          DEFAULT: '#06b6d4',
          light: '#22d3ee',
          dark: '#0891b2',
        },
        success: {
          DEFAULT: '#22c55e',
          light: '#4ade80',
          dark: '#16a34a',
        },
        danger: {
          DEFAULT: '#ef4444',
          light: '#f87171',
          dark: '#dc2626',
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
