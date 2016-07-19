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
use Carbon\Carbon;

class AllocationController extends Controller
{

  public function getBoardSelection()
  {
    $page_title = "<i class='fa fa-calendar'></i> Visualizar Quadro de Reservas";
    $page_description = "Selecione um recurso para visualizar o quadro de reserva.";

    $recursos = DB::table("tb_equipamento")->join("tb_tipo", "tb_equipamento.tipoId", "=", "tb_tipo.tipoId")
                                           ->select("tb_tipo.tipoNome as tipo", "equId as id", "equNome as nome")
                                           ->where("equStatus", 1)
                                           ->orderBy("equNome", "asc")
                                           ->get();

    Session::put("menu", "quadro");
    return View::make("admin.actions.boardSelection")->with(["page_description" => $page_description, "page_title" => $page_title, "recursos" => $recursos]);
  }

  public function viewBoard() {
    date_default_timezone_set('America/Sao_Paulo');

    if(Session::has("allocRedir")) $recursoID = Session::get('allocRedir');
    else $recursoID = Input::get("recurso");

    if(is_null($recursoID)) {
      Log::warning("O Usuário " . Session::get('id') . " de nome " . Session::get('nome') ." tentou acessar o quadro de viualização provavelmente via POST sem o ID do recurso.");
      return Redirect::route('getAlocarView');
    }

    $recursoNome = DB::table('tb_equipamento')->select("equNome as nome")->where("equId", $recursoID)->first();

    $page_title = "<i class='fa fa-calendar'></i> Visualizar Quadro de Reservas";
    $page_description = "Quadro de reservas do recurso " . $recursoNome->nome . " para esta semana";

    $regras = DB::table('tb_horario')->select('horNumAulaManha as manha', 'horNumAulaTarde as tarde', 'horNumAulaNoite as noite', 'horNumDias as diasQtd', 'inicioManha', 'inicioTarde', 'inicioNoite')->first();

    // pegar todos os dias da semana com data e nome
    $diasSemana = [];
    if(Session::has("id")) $diasPossiveis = (int) $regras->diasQtd;
    else $diasPossiveis = 8; // caso não seja um usuário do sistema, o visitante só pode ver os 8 próximos dias

    $diaInicio = Carbon::now()->subDays(1);
    $diaFinal = Carbon::now()->addDays($diasPossiveis);

    $alocacoes = DB::table('tb_alocacao')->join('ldapusers', 'cpf', '=', 'tb_alocacao.usuId')
                                         ->select("aloId as reservaID", "cpf as autorID", "nome as autorNOME", "email as autorEMAIL", "equId as recursoID", "aloData as data", "aloAula as aula")
                                         ->where(DB::raw("STR_TO_DATE(aloData, '%d/%m/%y')"), ">=", $diaInicio)
                                         ->where(DB::raw("STR_TO_DATE(aloData, '%d/%m/%y')"), "<=", $diaFinal)
                                         ->where("equId", $recursoID)
                                         ->get();



    for ($i = 0; $i < $diasPossiveis; ++$i) {
      $diasSemana[$i] = Carbon::now()->addDays($i)->format('j/m/y');
    }

    if(Session::get("menu") == "allocRecurso") $view = "admin.actions.allocView";
    else $view = 'admin.actions.boardView';
    Session::forget("allocRedir");
    return View::make($view)->with(["page_description" => $page_description, "page_title" => $page_title, "alocacoes" => $alocacoes, "recursoNome" => $recursoNome->nome, "recursoID" => $recursoID, "dias" => $diasSemana, "regras" => $regras, 'diasPossiveis' => $diasPossiveis]);
  }

  public function getAllocSelection()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    $page_title = "<i class='fa fa-calendar-plus-o'></i> Selecionar recurso";
    $page_description = "Selecione um recurso para visualizar o quadro de reserva.";

    $recursos = DB::table("tb_equipamento")->join("tb_tipo", "tb_equipamento.tipoId", "=", "tb_tipo.tipoId")
                                           ->select("tb_tipo.tipoNome as tipo", "equId as id", "equNome as nome")
                                           ->where("equStatus", 1)
                                           ->orderBy("equNome", "asc")
                                           ->get();

    Session::put("menu", "allocRecurso");
    return View::make("admin.actions.allocSelection")->with(["page_description" => $page_description, "page_title" => $page_title, "recursos" => $recursos]);
  }

  public function getAllocationBoard()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    $page_title = "<i class='fa fa-calendar-plus'></i> Alocar recurso";
    $page_description = "Selecione as datas para alocar o recurso.";

    return View::make("admin.actions.allocView");
  }

  public function allocateResource()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    $usuarioID = Session::get("id");
    $equipamentoID = (int)Input::get('id');

    $form = Input::all();
    $insert = [];
    $i = 0;

    foreach ($form as $input) {
      if(strrchr($input, ".")) { // se houver o horario e a data
        $data = substr($input, 3);
        $aula = substr($input, 0, 2);
        $insert[$i] = array('aloData' => $data, 'aloAula' => $aula, 'usuId' => $usuarioID, 'equId' => $equipamentoID);
        ++$i;
      }
    } // end for each

    $qtd = DB::table('tb_alocacao')->insert($insert);
    $tipo = "Erro";
    if($qtd == (count($form) - 2)) {
      $tipo = "Sucesso";
      $mensagem = "Recurso reservado com sucesso.";
    }
    else $mensagem = "Falha de SQL ao inserir reservas";

    Session::put("allocRedir", $equipamentoID);
    Session::flash("mensagem", $mensagem);
    Session::flash("tipo", $tipo);
    return Redirect::route("getResourceBoard");
  }

  public function freeResource($id)
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    $reservista = DB::table("tb_alocacao")->select("usuId as id", "equId as equipamento")->where("aloId", $id)->first();
    if(Session::get("nivel") == 1 || $reservista->id == Session::get("id")) {
      $deleted = DB::table('tb_alocacao')->where("aloId", $id)->delete();
      Session::put("allocRedir", $reservista->equipamento);

      if($deleted) {
        $tipo = "Sucesso";
        $mensagem = "Recurso desalocado com sucesso.";
      }
      else {
        $tipo = "Erro";
        $mensagem = "Erro ao tentar desalocar o recurso.";
      }
      Session::flash("tipo", $tipo);
      Session::flash("mensagem", $mensagem);
      return Redirect::route("getResourceBoard");
    }
    else abort(403);
  }

  public function getViewAllocDate()
  {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");
    else {
      Session::put('menu', 'viewReserva');
      $resources = DB::table('tb_equipamento')->select('equID as id', 'equNome as nome')->get();
      return View::make('admin.actions.viewAllocDate')->with(['page_title' => '<i class="fa fa-search"></i> Consultar Reserva', 'page_description' => 'Selecione uma data e um laboratório para consultar as reservas daquele dia', 'recursos' => $resources]);
    }
  }

  public function searchAllocationAt($date, $resource)
  {
    $newAllocations = DB::table('tb_alocacao')->join('ldapusers', 'cpf', '=', 'usuId')
                                              ->select('nome', 'email', 'aloAula as aula')
                                              ->where('aloData', $date)
                                              ->where('equId', $resource)
                                              ->get();

    $oldAllocations = DB::table('tb_alocacao')->join('tb_usuario', 'tb_usuario.usuId', '=', 'tb_alocacao.usuId')
                                              ->select('tb_usuario.usuNome as nome', 'tb_usuario.usuEmail as email', 'aloAula as aula')
                                              ->where('aloData', $date)
                                              ->where('equId', $resource)
                                              ->get();

    $allocations = array_merge($oldAllocations, $newAllocations);
    return $allocations;
  }

  public function showAllocationAt() {
    if(!UserController::checkLogin()) return Redirect::route("getLogin");

    if(UserController::checkPermissions(1)) {
      $form = Input::all();
      $allocations = $this->searchAllocationAt($form['data'], $form['recurso']);
      $regras = DB::table('tb_horario')->select('horNumAulaManha as manha', 'horNumAulaTarde as tarde', 'horNumAulaNoite as noite', 'horNumDias as diasQtd', 'inicioManha', 'inicioTarde', 'inicioNoite')->first();

      return View::make('admin.actions.showAllocAt')->with(['alocacoes' => $allocations, 'page_title' => '<i class="fa fa-search"></i> Consulta de Reserva' ,'page_description' => 'Alocações para o dia ' . $form['data'], 'regras' => $regras]);

    }
    else abort(403);
  }
}
