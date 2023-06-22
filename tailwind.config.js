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

            keyframes: {
                wave: {
                    '0%': {transform: 'rotate(0.0deg)'},
                    '10%': {transform: 'rotate(14deg)'},
                    '20%': {transform: 'rotate(-8deg)'},
                    '30%': {transform: 'rotate(14deg)'},
                    '40%': {transform: 'rotate(-4deg)'},
                    '50%': {transform: 'rotate(10.0deg)'},
                    '60%': {transform: 'rotate(0.0deg)'},
                    '100%': {transform: 'rotate(0.0deg)'},
                },
            },
            animation: {
                'waving-hand': 'wave 2s linear infinite',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
