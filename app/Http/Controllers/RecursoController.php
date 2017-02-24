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
use App\TipoRecurso;
use App\Asset;

class RecursoController extends Controller
{
    /**
     * Renderiza uma view com o formulário para adição de um novo recurso.
     */
    public function add()
    {
        $tipos = TipoRecurso::select('tipoNome as nome', 'tipoId as id')->get();
        return View::make('asset.add')->with(['tipos' => $tipos]);
    }

    /**
     * Renderiza uma view contendo a lista de todos os recursos cadastrados.
     */
    public function show()
    {
        $recursos = DB::table("tb_equipamento")->join("tb_tipo", "tb_equipamento.tipoId", "=", "tb_tipo.tipoId")
            ->select("tb_tipo.tipoNome as tipo", "equId as id", "equNome as nome", "equDescricao as descricao", "equStatus as status")
            ->orderBy("tb_tipo.tipoNome", "asc")
            ->orderBy("equStatus", "desc")
            ->orderBy("equNome", "asc")
            ->get();

        return View::make('asset.show')->with(['recursos' => $recursos]);
    }

    /**
     * Adiciona um novo recurso ao sistema
     */
    public function store()
    {
        $tipo = "Erro";
        $form = Input::all();

        $id = Asset::create(['tipoId' => $form['tipo'], 'equNome' => $form['nome'], 'equDescricao' => $form['descricao'], 'equStatus' => $form['status']]);

        if(isset($id))
        {
            $tipo = "Sucesso";
            $mensagem = "Recurso adicionado com sucesso.";
        }
        else $mensagem = "Falha do banco dados.";

        Session::flash("mensagem", $mensagem);
        Session::flash("tipo", $tipo);

        return Redirect::route("showAsset");
    }

    /**
     * Renderiza uma view com um formulário de edição dos dados de um recurso.
     * @param $id ID do recurso
     */
    public function details($id)
    {
        $recurso = Asset::select("tipoId as tipo", "equId as id", "equNome as nome", "equDescricao as descricao", "equStatus as status")->where('equId', $id)->first();
        $tipos = TipoRecurso::select('tipoNome as nome', 'tipoId as id')->get();

        if(empty($recurso) || empty($tipos))
        {
            Session::flash("tipo", "Erro");
            Session::flash("mensagem", "Erro no banco de dados. Impossível obter os dados do recurso!");
        }

        return View::make('asset.edit')->with(['recurso' => $recurso, 'tipos' => $tipos]);

    }

    /**
     * Modifica os dados de um recurso
     */
    public function edit()
    {
        $form = Input::all();
        $tipo = "Erro";

        $updated = Asset::where('equId', $form['id'])->update(['equNome' => $form['nome'], 'tipoID' => $form['tipo'], 'equDescricao' => $form['descricao'], 'equStatus' => $form['status']]);

        if($updated == 1)
        {
            $tipo = "Sucesso";
            $mensagem = "Atualização feita com sucesso!";
        }
        else $mensagem = "Erro no banco de dados.";

        Session::flash("mensagem", $mensagem);
        Session::flash("tipo", $tipo);
        return Redirect::back();
    }

    /**
     * Modifica o status de um recurso para inativo. Não pode ser removido do banco para não se perder as referências históricas.
     */
    public function delete()
    {
        $id = Input::get("id");
        $tipo = "Erro";
        $mensagem = "Ação não executada! ";

        try
        {
            $deleted = Asset::where('equId', $id)->update(['equStatus' => 0]);
        }
        catch(\Illuminate\Database\QueryException $ex)
        {
            $deleted = 0;
            $mensagem .= $ex->getMessage();
        }

        if($deleted == 1)
        {
            $tipo = "Sucesso";
            $mensagem = "Recurso removido com sucesso! Ele ainda existe no banco de dados mas não poderá ser reservado por ninguém.";
        }

        Session::flash("mensagem", $mensagem);
        Session::flash("tipo", $tipo);
        return Redirect::route('showAsset');
    }
}
