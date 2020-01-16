const mix = require('laravel-mix');
const localDomain = 'airlock.test';
require('laravel-mix-auto-extract');

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
  .disableSuccessNotifications()
  .autoload({ uikit: 'UIkit' })
  .js('resources/js/app.js', 'public/js')
  .standaloneSass('resources/sass/app.scss', 'public/css', {
    includedPaths: ['node_modules']
  })
  .sourceMaps()
  .autoExtract()
  .browserSync({
    proxy: 'http://' + localDomain,
    host: localDomain,
    notify: false,
    open: false,
    injectChanges: true,
    // https: {
    //   key: '/Users/YOUR_COMPUTER/.config/valet/Certificates/YOUR_SITE.test.key',
    //   cert: '/Users/YOUR_COMPUTER/.config/valet/Certificates/YOUR_SITE.test.crt'
    // }
  })

if (mix.inProduction()) {
  mix.version();
}
