import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

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
            },
            animation: {
                fadeIn: 'fadeIn 0.3s ease-out forwards',
            },
            keyframes: {
                fadeIn: {
                    from: { opacity: 0, transform: 'scale(0.95)' },
                    to: { opacity: 1, transform: 'scale(1)' },
                },
            },
        },
    },

    plugins: [forms],
}
