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


class RulesController extends Controller
{
  public function getRules()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    if(UserController::checkPermissions(1)) {
      $regras = DB::table("tb_horario")->select("horNumAulaManha as manha", "horNumAulaTarde as tarde", "horNumAulaNoite as noite", "horNumDias as dias", "horId as id")->first();
      $page_title = "<i class='fa fa-gears'></i> Consulta de Regras";
      $page_description = "Resumo das regras de horários que regem o sistema.";
      Session::put("menu", "regras");
      return View::make('admin.actions.viewRules')->with(['regras' => $regras, 'page_title' => $page_title, 'page_description' => $page_description]);
    }
    else abort(401);
  }

  public function getEditRules($id)
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    if(UserController::checkPermissions(1)) {
      $regras = DB::table("tb_horario")->select("horNumAulaManha as manha", "horNumAulaTarde as tarde", "horNumAulaNoite as noite", "horNumDias as dias", "horId as id")
                                       ->where("horId", "=", $id)
                                       ->first();

      if(empty($regras)) abort(404); // erro de sql
      else {
        $page_title = "<i class='fa fa-gears'></i> Edição de Regras";
        $page_description = "Edite a quantidade de horários por turno e a quantidade de dias disponíveis para reserva.";
        return View::make('admin.actions.editRules')->with(['regras' => $regras, 'page_title' => $page_title, 'page_description' => $page_description]);
      }
    }
    else abort(401);
  }

  public function editRules()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    if(UserController::checkPermissions(1)) {
      $form = Input::all();
      $tipo = "Erro";

      $updated = DB::table("tb_horario")->where('horId', $form['id'])
                                        ->update(['horNumAulaManha' => $form['manha'], 'horNumAulaTarde' => $form['tarde'], 'horNumAulaNoite' => $form['noite'],
                                                  'horNumDias' => $form['dias']]);

      if($updated == 1) {
        $tipo = "Sucesso";
        $mensagem = "Atualização feita com sucesso!";
      }
      else $mensagem = "Erro no banco de dados. Regras não foram atualizadas.";

      Session::flash("tipo", $tipo);
      Session::flash("mensagem", $mensagem);
      return Redirect::to('/regras/editar/' . $form['id']);
    }
    else abort(403);
  }

}
