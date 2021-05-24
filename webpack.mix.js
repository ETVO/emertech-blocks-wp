let mix = require("laravel-mix");

mix.disableSuccessNotifications();

mix
    .js('src/js/blocks.js', 'js/')
    .sass('src/scss/blocks.scss', 'css/')
    .sass('src/scss/editor.scss', 'css/')
    .setPublicPath("assets/");
