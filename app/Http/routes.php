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

Route::group(['middleware' => 'auth'], function()
{

    // Rotas que somente administradores tem acesso
    Route::group(['middleware' => 'can:administrate'], function() {

        // Rotas de CRUD de usuário
        Route::group(['prefix' => 'usuarios'], function() {
            Route::get('/', ['as' => 'usuario.index', 'uses' => 'UsuarioController@index']);
            Route::get('cadastrar', ['as' => 'usuario.create', 'uses' => 'UsuarioController@create']);
            Route::post('cadastrar', ['as' => 'usuario.store', 'uses' => 'UsuarioController@store']);
            Route::get('editar/{usuario}', ['as' => 'usuario.edit', 'uses' => 'UsuarioController@edit']);
            Route::post('editar', ['as' => 'usuario.update', 'uses' => 'UsuarioController@update']);
            Route::post('deletar', ['as' => 'usuario.destroy', 'uses' => 'UsuarioController@destroy']);
        });

        // Rotas de regras de negócio
        Route::resource('regra', 'RegraController', ['only' =>['index', 'edit', 'update']]);

        // Rotas relacionadas com manipulação dos registros de bugs
        Route::group(['prefix' => 'bug'], function() {
            Route::get('/', ['as' => 'bug.index', 'uses' => 'BugController@index']);
            Route::get('visualizar/{bug}', ['as' => 'bug.show', 'uses' => 'BugController@show']);
            Route::delete('deletar/{bug}', ['as' => 'bug.destroy', 'uses' => 'BugController@destroy']);
        });

        // Rotas relacionadas aos recursos
        Route::group(['prefix' => 'recursos'], function() {
            Route::get('cadastrar', ['as' => 'recurso.create', 'uses' => 'RecursoController@create']);
            Route::post('cadastrar', ['as' => 'recurso.store', 'uses' => 'RecursoController@store']);
            Route::get('editar/{recurso}', ['as' => 'recurso.edit', 'uses' => 'RecursoController@edit']);
            Route::patch('editar/{recurso}', ['as' => 'recurso.update', 'uses' => 'RecursoController@update']);
            Route::delete('deletar/{recurso}', ['as' => 'recurso.destroy', 'uses' => 'RecursoController@destroy']);

            // Rotas para consulta de uma alocação em um dia específico
            Route::get('reserva/consulta', ['as' => 'selectDetailsAllocation', 'uses' => 'ReservaController@select']);
            Route::post('reserva/consulta', ['as' => 'detailsAllocation', 'uses' => 'ReservaController@details']);
        });

        // Rotas relacionadas aos tipos de recursos
        Route::resource('tiporecurso', 'TipoRecursoController', ['except' => 'show']);

        // Rotas relacionadas aos softwares instalados
        Route::resource('software', 'SoftwareController', ['except' => ['index', 'show']]);

        // Rotas relacionadas aos fabricantes de software
        Route::resource('fabricante', 'FabricanteSoftwareController', ['except' => 'show']);

        // Rota que mostra os logs do sistema
        Route::get('logs', ['as' => 'showLogs', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
    }); // Fim de rotas administrativas

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

    // Rotas relacionadas com manipulação dos registros de bugs
    Route::group(['prefix' => 'bug'], function() {
        Route::get('adicionar', ['as' => 'bug.create', 'uses' => 'BugController@create']);
        Route::post('adicionar', ['as' => 'bug.store', 'uses' => 'BugController@store']);
    });

    // Rota para listagem softwares
    Route::resource('software', 'SoftwareController', ['only' => 'index']);
});

Route::get('quadro/selecionar', ['as' => 'selectAllocatedAsset', 'uses' => 'ReservaController@select']);
Route::post('quadro/visualizar', ['as' => 'showAllocatedAssetBoard', 'uses' => 'ReservaController@show']);

Route::get('sobre', ['as' => 'showAbout', 'uses' => 'DashboardController@showAbout']);

Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');