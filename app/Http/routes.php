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
Route::get('quadro/selecionar', ['as' => 'selectAllocatedAsset', 'uses' => 'ReservaController@select']);
Route::post('quadro/visualizar', ['as' => 'showAllocatedAssetBoard', 'uses' => 'ReservaController@show']);

// Rota da página contentno informações sobre o sistema
Route::get('about', ['as' => 'about.show', 'uses' => 'DashboardController@showAbout']);

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

    // Rotas relacionadas aos recursos
    Route::group(['prefix' => 'recurso'], function() {
        Route::get('selecionar', ['as' => 'selectAllocation', 'uses' => 'ReservaController@select']);
        Route::get('reserva/quadro', 'ReservaController@show'); // tratamento para redirecionamentos
        Route::post('reserva/quadro', ['as' => 'addAllocation', 'uses' => 'ReservaController@show']);
        Route::post('reservar', ['as' => 'storeAllocation', 'uses' => 'ReservaController@store']);
        Route::get('consultar', ['as' => 'recurso.index', 'uses' => 'RecursoController@index']);
        Route::get('cancelar/{reserva}', ['as' => 'deleteAllocation', 'uses' => 'ReservaController@delete'])->middleware('can:manipularReserva,reserva');
        Route::get('favorito/{recurso}', ['as' => 'favoriteAllocation', 'uses' => 'DashboardController@favoriteResourceRedirection']);
    });

    // Rota para listagem softwares
    Route::resource('software', 'SoftwareController', ['only' => 'index']);

    // Rotas relacionadas com manipulação dos registros de bugs
    Route::resource('bug', 'BugController', ['only' => ['create', 'store']]);

    // Rotas que somente administradores tem acesso
    Route::group(['middleware' => 'can:administrate'], function() {

        // Rotas de CRUD de usuário
        Route::resource('usuario', 'UsuarioController');

        // Rotas de regras de negócio
        Route::resource('regra', 'RegraController', ['only' =>['index', 'edit', 'update']]);

        // Rotas relacionadas com manipulação dos registros de bugs
        Route::resource('bug', 'BugController', ['only' => ['index', 'show', 'destroy']]);

        Route::group(['prefix' => 'recursos'], function() {
            // Rotas para consulta de uma alocação em um dia específico
            Route::get('reserva/consulta', ['as' => 'selectDetailsAllocation', 'uses' => 'ReservaController@select']);
            Route::post('reserva/consulta', ['as' => 'detailsAllocation', 'uses' => 'ReservaController@details']);
        });

        // Rotas relacionadas aos recursos
        Route::resource('recurso', 'RecursoController');

        // Rotas relacionadas aos tipos de recursos
        Route::resource('tiporecurso', 'TipoRecursoController', ['except' => 'show']);

        // Rotas relacionadas aos softwares instalados
        Route::resource('software', 'SoftwareController', ['except' => ['index', 'show']]);

        // Rotas relacionadas aos fabricantes de software
        Route::resource('fabricante', 'FabricanteSoftwareController', ['except' => 'show']);

        // Rota que mostra os logs do sistema
        Route::get('logs', ['as' => 'showLogs', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
    }); // Fim de rotas administrativas
});