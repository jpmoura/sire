<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Rotas para busca e visualização de reervas de recursos
Route::group(['prefix' => 'recurso'], function () {
    Route::get('selecionar', ['as' => 'recurso.select', 'uses' => 'RecursoController@select']);
    Route::get('selecionado', ['as' => 'recurso.selected', 'uses' => 'ReservaController@selectedRedirection']);
    Route::get('{recurso}/reserva', ['as' => 'reserva.show', 'uses' => 'ReservaController@show']);
});

// Rota da página contentno informações sobre o sistema
Route::get('sobre', ['as' => 'about.show', 'uses' => 'DashboardController@showAbout']);

// Rotas predefinidas pelo Laravel para autenticação de usuário
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

// Rotas para todos os usários autenticados
Route::group(['middleware' => 'auth'], function()
{
    // Rotas de páginas iniciais
    Route::get('/', ['as' => 'home', 'uses' => 'DashboardController@getHome']);
    Route::get('home', ['uses' => 'DashboardController@getHome']);
    Route::get('painel', ['as' => 'dashboard.show.regular', 'uses' => 'DashboardController@getRegularHome']);

    // Rotas relacionadas as reservas
    Route::group(['prefix' => 'reserva'], function() {
        Route::post('store', ['as' => 'reserva.store', 'uses' => 'ReservaController@store']);
        Route::delete('{reserva}', ['as' => 'reserva.destroy', 'uses' => 'ReservaController@destroy'])
            ->middleware('can:manipularReserva,reserva');
    });

    // Rota para listagem softwares
    Route::resource('software', 'SoftwareController', ['only' => 'index']);

    // Rotas relacionadas com manipulação dos registros de bugs
    Route::resource('bug', 'BugController', ['only' => ['create', 'store']]);

    // Rotas que somente administradores tem acesso
    Route::group(['middleware' => 'can:administrate'], function() {

        Route::get('painel/administrador', ['as' => 'dashboard.show.administrador', 'uses' => 'DashboardController@getAdministradorHome']);

        // Rotas relacionadas aos recursos
        Route::group(['prefix' => 'recurso'], function() {
            // Rotas para consulta de uma alocação em um dia específico
            Route::get('selecionar/data', ['as' => 'recurso.select.date', 'uses' => 'RecursoController@selectByDate']);
            Route::get('selecionado/data', ['as' => 'recurso.selected.date', 'uses' => 'ReservaController@selectedByDateRedirection']);
            Route::get('{recurso}/data', ['as' => 'reserva.show.date', 'uses' => 'ReservaController@specificDate']);
        });
        Route::resource('recurso', 'RecursoController');

        // Rotas de CRUD de usuário
        Route::resource('usuario', 'UsuarioController');

        // Rotas de regras de negócio
        Route::resource('regra', 'RegraController', ['only' =>['index', 'edit', 'update']]);

        // Rotas relacionadas com manipulação dos registros de bugs
        Route::resource('bug', 'BugController', ['only' => ['index', 'show', 'destroy']]);

        // Rotas relacionadas aos tipos de recursos
        Route::resource('tiporecurso', 'TipoRecursoController', ['except' => 'show']);

        // Rotas relacionadas aos softwares instalados
        Route::resource('software', 'SoftwareController', ['except' => ['index', 'show']]);

        // Rotas relacionadas aos fabricantes de software
        Route::resource('fabricante', 'FabricanteSoftwareController', ['except' => 'show']);

        // Rota que mostra os logs do sistema
        Route::get('logs', ['as' => 'log.index', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
    }); // Fim de rotas administrativas
});