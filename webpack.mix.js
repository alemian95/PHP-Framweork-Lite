let mix = require("laravel-mix");

mix.setPublicPath('public').version();

mix.sass("resources/sass/main.scss", 'css');
mix.js("resources/js/main.js", "js");