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
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                base: {
                    bg: 'var(--color-bg)',
                    surface: 'var(--color-surface)',
                    elevated: 'var(--color-elevated)',
                    border: 'var(--color-border)',
                },
                text: {
                    primary: 'var(--color-text-primary)',
                    muted: 'var(--color-text-muted)',
                    dim: 'var(--color-text-dim)',
                },
                accent: {
                    DEFAULT: 'var(--color-accent)',
                    orange: 'var(--color-accent-orange)',
                    green: 'var(--color-accent-green)',
                },
                dark: {
                    bg: 'var(--color-bg)',
                    surface: 'var(--color-surface)',
                    elevated: 'var(--color-elevated)',
                    border: 'var(--color-border)',
                },
                neon: {
                    cyan: 'var(--color-accent)',
                    orange: 'var(--color-accent-orange)',
                    green: 'var(--color-accent-green)',
                },
            },
            boxShadow: {
                'glow-sm': '0 0 12px var(--color-glow)',
                'glow': '0 0 24px var(--color-glow)',
                'glow-lg': '0 0 40px var(--color-glow)',
                'glow-orange': '0 0 24px var(--color-glow-orange)',
                'glow-green': '0 0 24px var(--color-glow-green)',
            },
        },
    },

    plugins: [forms],
};
