{{-- Tema espelhado de tailwind.config.js — sem build/Vite no deploy. Opcional: npm run build:css para gerar public/css/match.css. --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['"DM Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
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
    };
</script>
