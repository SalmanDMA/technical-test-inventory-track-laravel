/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                'poppins': ['Poppins', 'sans-serif'],
                'gelasio': ['Gelasio', 'serif'],
            },
            colors: {
                'primary': 'rgb(60,80,224)',
            }
        },
    },
    plugins: [],
}
