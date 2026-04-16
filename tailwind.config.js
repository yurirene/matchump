import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/**
 * @type {import('tailwindcss').Config}
 * Tema `heart`: ao alterar cores/fontes, atualize `resources/views/layouts/partials/heart-tailwind-cdn.blade.php`.
 */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"DM Sans"', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                heart: {
                    primary: 'hsl(346 77% 50%)',
                    'primary-foreground': 'hsl(0 0% 98%)',
                    accent: 'hsl(346 77% 97%)',
                    'accent-foreground': 'hsl(346 77% 40%)',
                    background: 'hsl(0 0% 100%)',
                    foreground: 'hsl(0 0% 9%)',
                    muted: 'hsl(0 0% 96.1%)',
                    'muted-foreground': 'hsl(0 0% 45.1%)',
                    border: 'hsl(0 0% 89.8%)',
                    card: 'hsl(0 0% 100%)',
                },
            },
            boxShadow: {
                heart: '0 10px 40px -10px hsl(346 77% 50% / 0.15)',
            },
        },
    },

    plugins: [forms],
};
