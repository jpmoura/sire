<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Session;
use Input;
use Illuminate\Support\Facades\Redirect;
use Log;

class ResourceController extends Controller
{
  public function getNewResource()
  {
    if(UserController::checkLogin()) {
      if(UserController::checkPermissions(1)) {
        $tipos = DB::table('tb_tipo')->select('tipoNome as nome', 'tipoId as id')->get();
        $page_title = "<i class='fa fa-plus-circle'></i> Cadastrar novo recurso";
        $page_description = "Complete o formulário pada cadastrar um novo recurso.";
        Session::put("menu", "addRecurso");
        return View::make('admin.actions.addResource')->with(['tipos' => $tipos, 'page_description' => $page_description, "page_title" => $page_title]);
      }
      else abort(401);
    }
    else Redirect::route("getLogin");
  }

  public function getResources()
  {
    if(UserController::checkLogin()) {
      $recursos = DB::table("tb_equipamento")->join("tb_tipo", "tb_equipamento.tipoId", "=", "tb_tipo.tipoId")
                                             ->select("tb_tipo.tipoNome as tipo", "equId as id", "equNome as nome", "equDescricao as descricao", "equStatus as status")
                                             ->orderBy("tb_tipo.tipoNome", "asc")
                                             ->orderBy("equStatus", "desc")
                                             ->orderBy("equNome", "asc")
                                             ->get();

      $page_title = "<i class='fa fa-search'></i> Consulta de Recursos";
      $page_description = "Essa a lista de todos os recursos cadastrados no sistema.";
      Session::put("menu", "viewRecurso");
      return View::make('admin.actions.viewResources')->with(['recursos' => $recursos, 'page_description' => $page_description, "page_title" => $page_title]);
    }
    else return Redirect::route("getLogin");
  }

  public function addNewResource()
  {
    if(UserController::checkLogin()) {
      if(UserController::checkPermissions(1)) {
        $tipo = "Erro";
        $form = Input::all();
        $id = DB::table("tb_equipamento")->insertGetId(['tipoId' => $form['tipo'], 'equNome' => $form['nome'], 'equDescricao' => $form['descricao'], 'equStatus' => $form['status']]);

        if(isset($id)) {
          $tipo = "Sucesso";
          $mensagem = "Equipamento adicionado com sucesso.";
        }
        else $mensagem = "Falha do banco dados.";

        Session::flash("mensagem", $mensagem);
        Session::flash("tipo", $tipo);
        return Redirect::route("viewRecursos");
      }
      else abort(401);
    }
    else Redirect::route("getLogin");
  }

  public function getEditResource($id)
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    if(UserController::checkPermissions(1)) {
      $recurso = DB::table("tb_equipamento")->select("tipoId as tipo", "equId as id", "equNome as nome", "equDescricao as descricao", "equStatus as status")
                                            ->where('equId', $id)
                                            ->first();

      $tipos = DB::table('tb_tipo')->select('tipoNome as nome', 'tipoId as id')->get();
      if(empty($recurso) || empty($tipos)) {
        Session::flash("tipo", "Erro");
        Session::flash("mensagem", "Erro no banco de dados. Impossível obter os dados do recurso!");
      }

      $page_title = "<i class='fa fa-edit'></i> Editar Recurso";
      $page_description = "Essa a lista de todos os recursos cadastrados no sistema.";
      return View::make('admin.actions.editResource')->with(["page_title" => $page_title, "page_description" => $page_description, 'recurso' => $recurso, 'tipos' => $tipos]);
    }
    else abort(401);
  }

  public function editResource()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    if(UserController::checkPermissions(1)) {
      $form = Input::all();
      $tipo = "Erro";

      $updated = DB::table('tb_equipamento')->where('equId', $form['id'])
                                            ->update(['equNome' => $form['nome'], 'tipoID' => $form['tipo'], 'equDescricao' => $form['descricao'], 'equStatus' => $form['status']]);

      if($updated == 1) {
        $tipo = "Sucesso";
        $mensagem = "Atualização feita com sucesso!";
      }
      else $mensagem = "Erro no banco de dados.";

      Session::flash("mensagem", $mensagem);
      Session::flash("tipo", $tipo);
      return Redirect::route("viewRecursos");
    }
    else abort(401);
  }

  public function deleteResource()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    if(UserController::checkPermissions(1)) {
      $id = Input::get("id");
      $tipo = "Erro";
      $mensagem = "Mensagem do banco de dados: ";

      try {
        $deleted = DB::table('tb_equipamento')->where('equId', $id)->delete();
      } catch(\Illuminate\Database\QueryException $ex){
        $deleted = 0;
        $mensagem = $mensagem . $ex->getMessage();
      }

      if($deleted == 1) {
        $tipo = "Sucesso";
        $mensagem = "Recurso removido com sucesso!";
      }

      Session::flash("mensagem", $mensagem);
      Session::flash("tipo", $tipo);
      return Redirect::route('viewRecursos');
    }
    else abort(403);

  }
}
