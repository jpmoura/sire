var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    // Fontes
    mix.copy('resources/assets/fonts', 'public/fonts');

    // Imagens
    mix.copy('resources/assets/img', 'public/img');

    // Plugins on demand
    mix.copy('resources/assets/js/datepicker', 'public/js/plugins/datepicker'); // Seleção de datas
    mix.copy('resources/assets/js/datatables', 'public/js/plugins/datatables'); // Organização e pesquisa em tabelas

    // CSS que não funcionam em conjunto
    // TODO verificar se usando SASS e LESS o erro é resolvido
    mix.copy('resources/assets/css/bootstrap', 'public/css/bootstrap');
    mix.copy('resources/assets/css/font-awesome', 'public/css/font-awesome');

    // Concatena todos os CSSs em um único arquivo
    mix.styles([
        // 'bootstrap/bootstrap.min.css',
        //'font-awesome/font-awesome.min.css',
        'adminLTE/AdminLTE.min.css',
        'adminLTE/skins/skin-ufop.css',
        'ufop.css'
    ], 'public/css/app.css', 'resources/assets/css/'); // Destino, path dos arquivos informados

    // Concatena todos os JavaScripts
    mix.scripts([
        'jQuery/jquery-2.2.4.min.js',
        'bootstrap/bootstrap.min.js',
        'adminLTE/app.min.js',
        'slimScroll/jquery.slimscroll.min.js',
        'fastclick/fastclick.min.js'
    ], 'public/js/app.js', 'resources/assets/js/'); // Destino, path dos arquivos informados

    // Versiona os arquivos gerados
    mix.version([
        'public/js/app.js',
        'public/css/app.css'
    ]);
});
