const mix = require('laravel-mix');

mix.js('resources/js/index.jsx', 'public/js/app.js')
   .react()
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
   ])
   .version();