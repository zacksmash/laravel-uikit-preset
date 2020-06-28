const mix = require('laravel-mix');
require('laravel-mix-auto-extract');

// Set project paths
const localDomain = 'http://laravel.test';

mix
  // Add global libraries
  .autoload({
    jquery: ['$', 'jQuery'],
    uikit: 'UIkit'
  })

  .setPublicPath('public')

  // Suppress success messages
  .disableSuccessNotifications()

  // Compile Javascript (ES6)
  .js('resources/js/app.js', 'public/js')

  // Compile Sass
  .standaloneSass('resources/scss/app.scss', 'public/css', {
    includedPaths: ['node_modules']
  })

  // .copy('resources/img', 'public/img')
  // .copy('resources/fonts', 'public/fonts')

  // Utilities
  .sourceMaps()
  .autoExtract()

  // Setup BrowserSync
  .browserSync({
    proxy: localDomain,
    host: localDomain.replace(/^https?:\/\//, ''),
    notify: false,
    open: false,
    injectChanges: true,
    // https: {
    //   key: '/Users/YOUR_COMPUTER/.config/valet/Certificates/YOUR_SITE.test.key',
    //   cert: '/Users/YOUR_COMPUTER/.config/valet/Certificates/YOUR_SITE.test.crt'
    // }
  })

// Setup versioning (cache-busting)
if (mix.inProduction()) {
  mix.version()
}
