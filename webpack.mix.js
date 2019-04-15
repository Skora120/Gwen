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

mix.js('resources/js/app.js', 'public/js').js('resources/js/demo/chart-area-demo.js', 'public/js/demo').js('resources/js/demo/chart-bar-demo.js', 'public/js/demo')
	.js('resources/js/demo/chart-pie-demo.js', 'public/js/demo').js('resources/js/demo/datatables-demo.js', 'public/js/demo')
   .sass('resources/sass/app.scss', 'public/css');
