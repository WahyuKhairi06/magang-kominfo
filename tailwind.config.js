import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
            colors: {
                primary: "#2D6A4F",
                secondary: "#0B3D26",
                tertiary: "#EEF3EF",
                neutral: "#FFFFFF",
                surface: "#EEF3EF",
                'on-surface': "#0B3D26",
                border: "#D9E4DC",
                muted: "#6B7D72",
                error: "#D92D20",
                // Sinkronisasi warna default tailwind ke palet baru
                slate: { 50: "#F5F8F6", 100: "#EEF3EF", 200: "#D9E4DC", 300: "#B8C9C0", 400: "#8FA397", 500: "#6B7D72", 600: "#4D6356", 700: "#324A3D", 800: "#0B3D26", 900: "#072919" },
                gray: { 50: "#F5F8F6", 100: "#EEF3EF", 200: "#D9E4DC", 300: "#B8C9C0", 400: "#8FA397", 500: "#6B7D72", 600: "#4D6356", 700: "#324A3D", 800: "#0B3D26", 900: "#072919" },
                zinc: { 50: "#F5F8F6", 100: "#EEF3EF", 200: "#D9E4DC", 300: "#B8C9C0", 400: "#8FA397", 500: "#6B7D72", 600: "#4D6356", 700: "#324A3D", 800: "#0B3D26", 900: "#072919" },
                neutral: { 50: "#F5F8F6", 100: "#EEF3EF", 200: "#D9E4DC", 300: "#B8C9C0", 400: "#8FA397", 500: "#6B7D72", 600: "#4D6356", 700: "#324A3D", 800: "#0B3D26", 900: "#072919" },
                stone: { 50: "#F5F8F6", 100: "#EEF3EF", 200: "#D9E4DC", 300: "#B8C9C0", 400: "#8FA397", 500: "#6B7D72", 600: "#4D6356", 700: "#324A3D", 800: "#0B3D26", 900: "#072919" },
                
                // Primary accents
                cyan: { 50: "#EEF3EF", 100: "#D9E4DC", 200: "#B8C9C0", 300: "#8FA397", 400: "#4CA376", 500: "#2D6A4F", 600: "#21513C", 700: "#0B3D26", 800: "#072919", 900: "#04160E" },
                green: { 50: "#EEF3EF", 100: "#D9E4DC", 200: "#B8C9C0", 300: "#8FA397", 400: "#4CA376", 500: "#2D6A4F", 600: "#21513C", 700: "#0B3D26", 800: "#072919", 900: "#04160E" },
                blue: { 50: "#EEF3EF", 100: "#D9E4DC", 200: "#B8C9C0", 300: "#8FA397", 400: "#4CA376", 500: "#2D6A4F", 600: "#21513C", 700: "#0B3D26", 800: "#072919", 900: "#04160E" },
                indigo: { 50: "#EEF3EF", 100: "#D9E4DC", 200: "#B8C9C0", 300: "#8FA397", 400: "#4CA376", 500: "#2D6A4F", 600: "#21513C", 700: "#0B3D26", 800: "#072919", 900: "#04160E" },
                purple: { 50: "#EEF3EF", 100: "#D9E4DC", 200: "#B8C9C0", 300: "#8FA397", 400: "#4CA376", 500: "#2D6A4F", 600: "#21513C", 700: "#0B3D26", 800: "#072919", 900: "#04160E" },
                pink: { 50: "#EEF3EF", 100: "#D9E4DC", 200: "#B8C9C0", 300: "#8FA397", 400: "#4CA376", 500: "#2D6A4F", 600: "#21513C", 700: "#0B3D26", 800: "#072919", 900: "#04160E" },
                teal: { 50: "#EEF3EF", 100: "#D9E4DC", 200: "#B8C9C0", 300: "#8FA397", 400: "#4CA376", 500: "#2D6A4F", 600: "#21513C", 700: "#0B3D26", 800: "#072919", 900: "#04160E" },
                emerald: { 50: "#EEF3EF", 100: "#D9E4DC", 200: "#B8C9C0", 300: "#8FA397", 400: "#4CA376", 500: "#2D6A4F", 600: "#21513C", 700: "#0B3D26", 800: "#072919", 900: "#04160E" },

                // Warning / Info
                yellow: { 50: "#FDF5E6", 100: "#FBE6C4", 200: "#F7CD93", 300: "#F3B05C", 400: "#EF942B", 500: "#E07B12", 600: "#B7620C", 700: "#8F4B08", 800: "#693605", 900: "#462202" },
                orange: { 50: "#FDF5E6", 100: "#FBE6C4", 200: "#F7CD93", 300: "#F3B05C", 400: "#EF942B", 500: "#E07B12", 600: "#B7620C", 700: "#8F4B08", 800: "#693605", 900: "#462202" },

                // Error palettes
                red: { 50: "#FCEAE8", 100: "#F8D0CD", 200: "#F1A8A3", 300: "#E97E77", 400: "#E2564C", 500: "#D92D20", 600: "#B12318", 700: "#871A12", 800: "#5F110C", 900: "#380906" },
                rose: { 50: "#FCEAE8", 100: "#F8D0CD", 200: "#F1A8A3", 300: "#E97E77", 400: "#E2564C", 500: "#D92D20", 600: "#B12318", 700: "#871A12", 800: "#5F110C", 900: "#380906" },
            }
        },
    },

    plugins: [forms],
};
