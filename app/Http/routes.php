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
            Route::get('consulta', ['as' => 'showUser', 'uses' => 'UsuarioController@show']);
            Route::get('cadastrar', ['as' => 'addUser', 'uses' => 'UsuarioController@add']);
            Route::post('cadastrar', ['as' => 'storeUser', 'uses' => 'UsuarioController@store']);
            Route::get('editar/{cpf}', ['as' => 'detailsUser', 'uses' => 'UsuarioController@details']);
            Route::post('editar', ['as' => 'editUser', 'uses' => 'UsuarioController@edit']);
            Route::post('deletar', ['as' => 'deleteUser', 'uses' => 'UsuarioController@delete']);
        });

        // Rotas de regras de negócio
        Route::group(['prefix' => 'regras'], function(){
            Route::get('/', ['as' => 'showRule', 'uses' => 'RegraController@show']);
            Route::get('editar/{regras}', ['as' => 'detailsRule', 'uses' => 'RegraController@details']);
            Route::post('editar/{regras}', ['as' => 'editRule', 'uses' => 'RegraController@edit']);
        });

        // Rotas relacionadas com manipulação dos registros de bugs
        Route::group(['prefix' => 'bug'], function() {
            Route::get('/', ['as' => 'bug.index', 'uses' => 'BugController@index']);
            Route::get('visualizar/{bug}', ['as' => 'bug.show', 'uses' => 'BugController@show']);
            Route::delete('deletar', ['as' => 'bug.destroy', 'uses' => 'BugController@destroy']);
        });

        // Rotas relacionadas aos recursos
        Route::group(['prefix' => 'recursos'], function() {
            Route::get('cadastrar', ['as' => 'recurso.create', 'uses' => 'RecursoController@add']);
            Route::post('cadastrar', ['as' => 'storeAsset', 'uses' => 'RecursoController@store']);
            Route::get('{recurso}/editar', ['as' => 'detailsAsset', 'uses' => 'RecursoController@details']);
            Route::post('{recurso}/editar', ['as' => 'editAsset', 'uses' => 'RecursoController@edit']);
            Route::post('deletar', ['as' => 'deleteAsset', 'uses' => 'RecursoController@delete']);

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
    Route::get('index.html', ['uses' => 'DashboardController@getHome']); // Tratamento do link do site do ICEA

    // Rotas relacionadas aos recursos
    Route::group(['prefix' => 'recurso'], function() {
        Route::get('selecionar', ['as' => 'selectAllocation', 'uses' => 'ReservaController@select']);
        Route::get('reserva/quadro', 'ReservaController@show'); // tratamento para redirecionamentos
        Route::post('reserva/quadro', ['as' => 'addAllocation', 'uses' => 'ReservaController@show']);
        Route::post('reservar', ['as' => 'storeAllocation', 'uses' => 'ReservaController@store']);
        Route::get('consultar', ['as' => 'showAsset', 'uses' => 'RecursoController@show']);
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

    // Rota para uso de AJAX durante adição de usuário pelo CPF
    Route::post('searchperson', ['as' => 'doSearch', 'uses' => 'UsuarioController@searchPerson']);
});

// Rotas que não é necessária autenticação
Route::get('login', ['as' => 'showLogin', 'middleware'  => 'guest', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('login', ['as' => 'login', 'middleware'  => 'guest', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('token/generate', ['as' => 'loginViaMiddleware', 'uses' => 'Auth\AuthController@generateMeuIceaToken']);
Route::get('token/login/{token}', ['as' => 'loginViaToken', 'uses' => 'Auth\AuthController@tokenLogin']);

Route::get('quadro/selecionar', ['as' => 'selectAllocatedAsset', 'uses' => 'ReservaController@select']);
Route::post('quadro/visualizar', ['as' => 'showAllocatedAssetBoard', 'uses' => 'ReservaController@show']);

Route::get('sobre', ['as' => 'showAbout', 'uses' => 'DashboardController@showAbout']);

Route::get('sair', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);