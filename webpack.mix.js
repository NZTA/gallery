let mix = require('laravel-mix');

mix.react(
  'client/js/index.jsx',
  'js/gallery.js'
);

mix.sass('client/scss/main.scss', 'css', {
  includePaths: ['node_modules/']
});

if (process.env.NODE_ENV === 'development') {
  mix.sourceMaps();
}
