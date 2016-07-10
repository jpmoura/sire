<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Session;
use Input;
use Illuminate\Support\Facades\Redirect;

class BugController extends Controller
{
  public function getBugForm()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    else {
      Session::put('menu', 'bugForm');
      return View::make('admin.actions.addBug')->with(['page_description' => 'Complete o formulário para informar um bug.', 'page_title' => '<i class="fa fa-bug"></i> Reportar Bug']);
    }
  }

  public function getBugView()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    elseif (UserController::checkPermissions(1)) {
      $bugs = DB::table('bugs')->join('ldapusers', 'cpf', '=', 'user')->select('title', 'id', 'nome')->get();
      Session::put('menu', 'bug');
      return View::make('admin.actions.viewBugs')->with(['page_description' => 'Lista de todos os bugs reportados por usuários.', 'page_title' => '<i class="fa fa-bug"></i> Visualizar Bugs', 'bugs' => $bugs]);
    }
    else abort(401);
  }

  public function getBugDetail($id)
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    elseif (UserController::checkPermissions(1)) {
      $bug = DB::table('bugs')->join('ldapusers', 'cpf', '=', 'user')->select('title', 'id', 'nome', 'description', 'email')->where('id', $id)->first();
      return View::make('admin.actions.viewBugDetail')->with(['page_description' => 'Informação detalhada do bug.', 'page_title' => '<i class="fa fa-search-plus"></i> Detalhes do Bug', 'bug' => $bug]);
    }
    else abort(401);
  }

  public function addBug()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    else {
      $tipo = "Erro";
      $form = Input::all();
      $id = DB::table('bugs')->insertGetId(['title' => $form['title'], 'description' => $form['description'], 'user' => $form['user']]);

      if(isset($id)) {
        $tipo = "Sucesso";
        $mensagem = "Bug reportado. Obrigado por contribuir para a melhoria do sistema :)";
      }
      else $mensagem = "Falha do banco dados.";

      Session::flash("mensagem", $mensagem);
      Session::flash("tipo", $tipo);

      return Redirect::back();
    }
  }

  public function deleteBug()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    elseif (UserController::checkPermissions(1)) {
      $tipo = "Erro";

      $status = DB::table('bugs')->where('id', Input::get('id'))->delete();

      if ($status) {
        $tipo = "Sucesso";
        $mensagem = "Bug foi excluído.";
      }
      else $mensagem = "Falha do banco dados. O bug não foi excluído.";

      Session::flash("mensagem", $mensagem);
      Session::flash("tipo", $tipo);

      return Redirect::route('getBugView');
    }
    else abort(403);
  }
}
