let mix = require('laravel-mix');

mix.sass('resources/assets/sass/app.scss', 'public/assets/styles');

if (mix.inProduction()) {
    mix.version();
}
