const mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js/app.js')
   .sass('resources/assets/sass/app.scss', 'public/css/app.css');
