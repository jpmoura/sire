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
            Route::get('consulta', ['as' => 'showUser', 'uses' => 'UserController@show']);
            Route::get('cadastrar', ['as' => 'addUser', 'uses' => 'UserController@add']);
            Route::post('cadastrar', ['as' => 'storeUser', 'uses' => 'UserController@store']);
            Route::get('editar/{cpf}', ['as' => 'detailsUser', 'uses' => 'UserController@details']);
            Route::post('editar', ['as' => 'editUser', 'uses' => 'UserController@edit']);
            Route::post('deletar', ['as' => 'deleteUser', 'uses' => 'UserController@delete']);
        });

        // Rotas de regras de negócio
        Route::group(['prefix' => 'regras'], function(){
            Route::get('/', ['as' => 'showRule', 'uses' => 'RuleController@show']);
            Route::get('editar', ['as' => 'detailsRule', 'uses' => 'RuleController@details']);
            Route::post('editar', ['as' => 'editRule', 'uses' => 'RuleController@edit']);
        });

        // Rotas relacionadas com manipulação dos registros de bugs
        Route::group(['prefix' => 'bug'], function() {
            Route::get('detalhe/{id}', ['as' => 'detailsBug', 'uses' => 'BugController@details']);
            Route::post('deletar', ['as' => 'deleteBug', 'uses' => 'BugController@delete']);
            Route::get('visualizar', ['as' => 'showBug', 'uses' => 'BugController@show']);
        });

        // Rotas relacionadas aos recursos
        Route::group(['prefix' => 'recursos'], function() {
            Route::get('cadastrar', ['as' => 'addAsset', 'uses' => 'AssetController@add']);
            Route::post('cadastrar', ['as' => 'storeAsset', 'uses' => 'AssetController@store']);
            Route::get('editar/{id}', ['as' => 'detailsAsset', 'uses' => 'AssetController@details']);
            Route::post('editar', ['as' => 'editAsset', 'uses' => 'AssetController@edit']);
            Route::post('deletar', ['as' => 'deleteAsset', 'uses' => 'AssetController@delete']);

            // Rotas para consulta de uma alocação em um dia específico
            Route::get('alocacao/consulta', ['as' => 'selectDetailsAllocation', 'uses' => 'AllocationController@select']);
            Route::post('alocacao/consulta', ['as' => 'detailsAllocation', 'uses' => 'AllocationController@details']);
        });

        // Rota que mostra os logs do sistema
        Route::get('logs', ['as' => 'showLogs', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
    }); // Fim de rotas administrativas

    // Rotas de páginas iniciais
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@getHome']);
    Route::get('home', ['uses' => 'HomeController@getHome']);
    Route::get('index.html', ['uses' => 'HomeController@getHome']); // Tratametno do link do site do ICEA

    // Rotas relacionadas aos recursos
    Route::group(['prefix' => 'recursos'], function() {
        Route::get('alocacao/selecionar', ['as' => 'selectAllocation', 'uses' => 'AllocationController@select']);
        Route::get('alocacao/quadro', 'AllocationController@show'); // tratamento para redirecionamentos
        Route::post('alocacao/quadro', ['as' => 'addAllocation', 'uses' => 'AllocationController@show']);
        Route::post('alocar', ['as' => 'storeAllocation', 'uses' => 'AllocationController@store']);
        Route::get('consulta', ['as' => 'showAsset', 'uses' => 'AssetController@show']);

        // TODO Uma guard para ser usada como middleware para checar se o usuário pode desalocar o recurso
        Route::get('desalocar/{id}', ['as' => 'deleteAllocation', 'uses' => 'AllocationController@delete']);
    });

    // Rotas relacionadas com manipulação dos registros de bugs
    Route::group(['prefix' => 'bug'], function() {
        Route::get('adicionar', ['as' => 'addBug', 'uses' => 'BugController@add']);
        Route::post('adicionar', ['as' => 'storeBug', 'uses' => 'BugController@store']);
    });

    // Rota para uso de AJAX durante adição de usuário pelo CPF
    Route::post('searchperson', ['as' => 'doSearch', 'uses' => 'UserController@searchPerson']);
});

// Rotas que não é necessária autenticação
Route::get('login', ['as' => 'showLogin', 'middleware'  => 'guest', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('login', ['as' => 'login', 'middleware'  => 'guest', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('token/generate', ['as' => 'loginViaMiddleware', 'uses' => 'Auth\AuthController@generateMeuIceaToken']);
Route::get('token/login/{token}', ['as' => 'loginViaToken', 'uses' => 'Auth\AuthController@tokenLogin']);

Route::get('quadro/selecionar', ['as' => 'selectAllocatedAsset', 'uses' => 'AllocationController@select']);
Route::post('quadro/visualizar', ['as' => 'showAllocatedAssetBoard', 'uses' => 'AllocationController@show']);

Route::get('sobre', ['as' => 'showAbout', 'uses' => 'HomeController@showAbout']);

Route::get('sair', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);