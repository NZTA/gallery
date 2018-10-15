let mix = require('laravel-mix');

mix.react(
  'src/js/index.jsx',
  'javascript/gallery.js'
);

mix.sass('src/scss/main.scss', 'css', {
  includePaths: ['node_modules/']
});

if (process.env.NODE_ENV === 'development') {
  mix.sourceMaps();
}
