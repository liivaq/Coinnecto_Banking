const defaultTheme = require('tailwindcss/defaultTheme');
const {emerald, black, blue, cyan, fuchsia, slate, gray, neutral, stone, green, indigo, lime, orange, pink, purple, red,
    rose, sky, teal, violet, amber, white
} = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: black,
            blue: blue,
            cyan: cyan,
            emerald: emerald,
            fuchsia: fuchsia,
            slate: slate,
            gray: gray,
            neutral: neutral,
            stone: stone,
            green: green,
            indigo: indigo,
            lime: lime,
            orange: orange,
            pink: pink,
            purple: purple,
            red: red,
            rose: rose,
            sky: sky,
            teal: teal,
            violet: violet,
            yellow: amber,
            white: white,
        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
