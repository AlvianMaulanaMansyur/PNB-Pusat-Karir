import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
            'customblue': '0px 4px 30px rgba(42, 34, 212, 0.5)'
            },
            colors: {
                'primaryColor' : '#4A3AFF',
                'darkBlue' : '#091A50'
            }
        },
    },

    plugins: [forms],
};
