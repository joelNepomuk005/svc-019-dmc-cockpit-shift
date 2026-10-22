const mix = require('laravel-mix');

require('laravel-mix-polyfill');

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
mix
    .js([
        'resources/scripts/bootstrap.js',
    ], 'public/scripts/vendor.js')
    .js([
        'resources/scripts/app/app.js',
        'resources/scripts/app/components/forms.js',
     ], 'public/scripts/app.js')
    .sass('resources/styles/sass/app.scss', 'public/styles',)
    .copyDirectory('resources/media', 'public/media')
;

// Cache Buster for all resources!
// if (mix.inProduction()) {
//     mix.version();
// }
