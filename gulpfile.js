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

    // Imagens
    mix.copy('resources/assets/img', 'public/img');

    // Plugins on demand
    mix.copy('resources/assets/js/datepicker', 'public/js/plugins/datepicker'); // Seleção de datas
    mix.copy('resources/assets/js/datatables', 'public/js/plugins/datatables'); // Organização e pesquisa em tabelas
    mix.copy('resources/assets/js/jQueryMask', 'public/js/plugins/jQueryMask'); // Máscaras de entradas
    mix.copy('resources/assets/js/chartjs', 'public/js/plugins/chartjs');

    // Compila o arquivos SASS contendo todos os CSS
    mix.sass('app.scss', 'public/css/');

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
