/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      colors: {
        'back': '#4a044e',
        'box': '#86198f',
        'shado': '#d946ef',
      },
      extend: {},
    },
    plugins: [
        require('flowbite/plugin')
    ],
  }

