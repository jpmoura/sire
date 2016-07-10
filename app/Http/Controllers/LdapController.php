<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Session;
use Input;
use Illuminate\Support\Facades\Redirect;

class LdapController extends Controller
{
  public function getLdapView()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    elseif (UserController::checkPermissions(1)) {
      $ldap = DB::table('ldap')->select('user', 'domain', 'server')->first();
      Session::put('menu', 'ldap');
      return View::make('admin.actions.viewLDAP')->with(['page_title' => 'Configurações LDAP', 'page_description' => 'Aqui estão as configurações atuais do servidor de autenticação.', 'ldap' => $ldap]);
    }
    else abort(401);
  }

  public function getEditLdap()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    elseif (UserController::checkPermissions(1)) {
      $ldap = DB::table('ldap')->select()->first();
      return View::make('admin.actions.editLDAP')->with(['page_title' => 'Configurações LDAP', 'page_description' => 'Altere os campos para atualizar a configuração.', 'ldap' => $ldap]);
    }
    else abort(401);
  }

  public function editLdap()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    elseif (UserController::checkPermissions(1)) {
      $form = Input::all();
      $ldap = DB::table('ldap')->where('id', 1)->update(['server' => $form['server'], 'user' => $form['user'], 'domain' => $form['domain'], 'password' => $form['password']]);
      return Redirect::back();
    }
    else abort(403);
  }
}
