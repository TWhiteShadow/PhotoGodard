/** @type {import('tailwindcss').Config} */
module.exports = {
  important: true,
  content: [
    "./node_modules/flowbite/**/*.js",
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}