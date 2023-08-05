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
                inter: ["Inter", "sans-serif"],
            },
            boxShadow: {
                xxs: "1px 1px 5px 1px rgba(0, 0, 0, 0.05)",
            },
        },
    },
    plugins: [],
};
