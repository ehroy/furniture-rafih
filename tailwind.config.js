/** @type {import('tailwindcss').Config} */
export default {
    purge: ["./resources/**/*.blade.php", "./resources/**/*.vue"],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {},
    },
    plugins: [require("flowbite/plugin"), require("@tailwindcss/typography")],
};
