const { mix } = require('laravel-mix');

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

//不需要打包
mix.copyDirectory('resources/assets/fonts','public/fonts');
mix.copyDirectory('resources/assets/img','public/img');

mix.styles([
    'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/oneui.css',
    'resources/assets/css/sweetalert.css',
], 'public/css/oneui.css');

mix.scripts([
    'resources/assets/js/plugins/jquery.min.js',
    'resources/assets/js/plugins/bootstrap.min.js',
    'resources/assets/js/plugins/jquery.scrollLock.min.js',
    'resources/assets/js/plugins/jquery.slimscroll.min.js',
    'resources/assets/js/plugins/common.js',    
], 'public/js/oneui.js');


//webpack打包
mix.webpackConfig({
    output: { chunkFilename: 'js/chunks/[name].js', publicPath: '/' },
});
mix.js('resources/assets/js/app.js', 'public/js').extract(['vue']);

if (mix.inProduction()) {
    mix.version();
}


