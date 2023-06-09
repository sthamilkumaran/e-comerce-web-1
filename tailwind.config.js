/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      colors: {
        'back': '#5F264A'
      },
      extend: {},
    },
    plugins: [
        require('flowbite/plugin')
    ],
  }

