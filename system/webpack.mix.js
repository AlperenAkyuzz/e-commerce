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
/*
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
*/
mix.setPublicPath('../');
mix.scripts([
    '../resources/js/bootstrap.min.js',
    '../resources/js/parallax.js',
    '../resources/js/revslider.js',
    '../resources/js/jquery.bxslider.min.js',
    '../resources/js/owl.carousel.min.js',
    '../resources/js/jquery.mobile-menu.min.js',
    '../resources/js/countdown.js',
    '../resources/js/toastr.js',
    '../resources/js/common.js',
    '../resources/js/cloud-zoom.js',
    '../resources/js/index/index.js',
    '../resources/js/product/events.js',
    '../resources/js/checkout/events.js',
    '../resources/js/category/events.js',
    '../resources/js/user/events.js'
], '../themes/organtic/assets/js/app.js')
    .styles([
        '../resources/css/bootstrap.min.css',
        '../resources/css/revslider.css',
        '../resources/css/owl.carousel.css',
        '../resources/css/owl.theme.css',
        '../resources/css/jquery.bxslider.css',
        '../resources/css/jquery.mobile-menu.css',
        '../resources/css/style.css',
        '../resources/css/responsive.css',
        '../resources/css/checkout.css',
        '../resources/css/user/login.css',
        '../resources/css/custom.css'
    ], '../themes/organtic/assets/css/app.css')
    .version();
