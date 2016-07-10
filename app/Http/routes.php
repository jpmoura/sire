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


  Route::get('/', ['as' => 'home', 'uses' => 'HomeController@getHome']);

  Route::get('/usuarios/consulta', ['as' => 'viewUsuarios', 'uses' => 'UserController@getUsers']);
  Route::get('/usuarios/editar/{cpf}', ['as' => 'editUsuarioView', 'uses' => 'UserController@getEditUser']);
  Route::post('/usuarios/editar', ['as' => 'editUsuarioActon', 'uses' => 'UserController@editUser']);
  Route::get('/usuarios/cadastrar', ['as' => 'addUsuarioView', 'uses' => 'UserController@getNewUser']);
  Route::post('/usuarios/cadastrar', ['as' => 'addUsuarioAction', 'uses' => 'UserController@addNewUser']);
  Route::post('/usuarios/deletar', ['as' => 'deleteUsuarioAction', 'uses' => 'UserController@deleteUser']);

  Route::get('/recursos/cadastrar', ['as' => 'addRecursoView', 'uses' => 'ResourceController@getNewResource']);
  Route::post('/recursos/cadastrar', ['as' => 'addRecursoAction', 'uses' => 'ResourceController@addNewResource']);
  Route::get('/recursos/editar/{id}', ['as' => 'editRecursoView', 'uses' => 'ResourceController@getEditResource']);
  Route::post('/recursos/editar', ['as' => 'editRecursoAction', 'uses' => 'ResourceController@editResource']);
  Route::post('/recursos/deletar', ['as' => 'deleteRecursoAction', 'uses' => 'ResourceController@deleteResource']);
  Route::get('/recursos/consulta', ['as' => 'viewRecursos', 'uses' => 'ResourceController@getResources']);

  Route::get('/regras', ['as' => 'viewRegras', 'uses' => 'RulesController@getRules']);
  Route::get('/regras/editar/{id}', ['as' => 'editRegrasView', 'uses' => 'RulesController@getEditRules']);
  Route::post('/regras/editar', ['as' => 'editRegrasAction', 'uses' => 'RulesController@editRules']);

  Route::get('/login', ['as' => 'getLogin', 'uses' => 'HomeController@getLogin']);
  Route::post('/login', ['as' => 'doLogin', 'uses' => 'UserController@doLogin']);

  Route::get('/sair', ['as' => 'doLogout', 'uses' => 'UserController@doLogout']);

  Route::get('/quadro/visualizar/', ['as' => 'getVisualizarView', 'uses' => 'AllocationController@getBoardSelection']);
  Route::post('/quadro/visualizar/', ['as' => 'postVisualizarView', 'uses' => 'AllocationController@viewBoard']);

  Route::get('/recursos/alocar', ['as' => 'getAlocarView', 'uses' => 'AllocationController@getAllocSelection']);
  Route::post('/recursos/alocar', ['as' => 'postAlocarView', 'uses' => 'AllocationController@viewBoard']);
  Route::post('/alocar', ['as' => 'postAlocarAction', 'uses' => 'AllocationController@allocateResource']);
  Route::get('/alocar', ['as' => 'getResourceBoard', 'uses' => 'AllocationController@viewBoard']);

  Route::get('/desalocar/{id}', ['as' => 'getDesallocAction', 'uses' => 'AllocationController@freeResource']);

  Route::get('/sobre', ['as' => 'getSobreView', 'uses' => 'HomeController@getSobre']);

  Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

  Route::get('/ldap', ['as' => 'viewLDAP', 'uses' => 'LdapController@getLdapView']);
  Route::get('/ldap/editar', ['as' => 'getEditLdap', 'uses' => 'LdapController@getEditLdap']);
  Route::post('/ldap/editar', ['as' => 'postEditLdapAction', 'uses' => 'LdapController@editLdap']);

  Route::get('/bug/adicionar', ['as' => 'addBugView', 'uses' => 'BugController@getBugForm']);
  Route::post('/bug/adicionar', ['as' => 'postBugAction', 'uses' => 'BugController@addBug']);
  Route::post('/bug/deletar', ['as' => 'deleteBug', 'uses' => 'BugController@deleteBug']);
  Route::get('/bug/visualizar', ['as' => 'getBugView', 'uses' => 'BugController@getBugView']);
  Route::get('/bug/detalhe/{id}', ['as' => 'getBugDetail', 'uses' => 'BugController@getBugDetail']);

  Route::post('/searchperson', ['as' => 'doSearch', 'uses' => 'UserController@searchPerson']);
