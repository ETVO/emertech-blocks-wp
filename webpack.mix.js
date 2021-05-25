let mix = require("laravel-mix");

mix.disableSuccessNotifications();

mix
    .js('src/js/blocks.js', 'js/')
    .js('src/js/front.js', 'js/')
    .sass('src/scss/blocks.scss', 'css/')
    .sass('src/scss/editor.scss', 'css/')
    .setPublicPath("assets/");
