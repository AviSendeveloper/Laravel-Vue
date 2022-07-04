const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([
    'resources/js/app.js',
    'public/css/assets/vendor/js/helpers.js',
    'public/css/assets/js/config.js',
    'public/css/assets/vendor/libs/jquery/jquery.js',
    'public/css/assets/vendor/libs/popper/popper.js',
    'public/css/assets/vendor/js/bootstrap.js',
    'public/css/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
    'public/css/assets/vendor/js/menu.js',
    'public/css/assets/vendor/libs/apex-charts/apexcharts.js',
    'public/css/assets/js/main.js',
    'public/css/assets/js/dashboards-analytics.js',
], 'public/js').vue();

mix.styles([
    // put css file to compile and use it in vue component
    'public/css/assets/vendor/css/core.css',
    'public/css/assets/vendor/css/theme-default.css',
    'public/css/assets/css/demo.css',
    'public/css/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css',
    'public/css/assets/vendor/libs/apex-charts/apex-charts.css',
    'public/img/avatars',
    'public/img/backgrounds',
    'public/img/elements',
    'public/img/favicon',
    'public/img/icons',
    'public/img/illustrations',
    'public/img/layouts',
], 'public/css/app.css');