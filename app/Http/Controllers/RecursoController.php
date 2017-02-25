<?php

namespace App\Http\Controllers;

use App\Recurso;
use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use Log;
use App\TipoRecurso;

class RecursoController extends Controller
{
    /**
     * Renderiza uma view com o formulário para adição de um novo recurso.
     */
    public function add()
    {
        return view('recurso.add')->with(['tipos' => TipoRecurso::all()]);
    }

    /**
     * Renderiza uma view contendo a lista de todos os recursos cadastrados.
     */
    public function show()
    {
        $recursos = Recurso::with('tipo')->get()->sortBy('nome');
        return view('recurso.show')->with(['recursos' => $recursos]);
    }

    /**
     * Adiciona um novo recurso ao sistema
     */
    public function store()
    {
        $tipo = "Erro";
        $form = Input::all();

        $id = Recurso::create([
            'tipo_recurso_id' => $form['tipo'],
            'nome' => $form['nome'],
            'descricao' => $form['descricao'],
            'status' => $form['status']
        ]);

        if(isset($id))
        {
            $tipo = "Sucesso";
            $mensagem = "Recurso adicionado com sucesso.";
        }
        else $mensagem = "Falha do banco dados.";

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route("showAsset");
    }

    /**
     * Renderiza uma view com um formulário de edição dos dados de um recurso.
     * @param Recurso $recurso Instância do recurso a ser editada
     */
    public function details(Recurso $recurso)
    {
        $tipos = TipoRecurso::all();
        return view('recurso.edit')->with(['recurso' => $recurso, 'tipos' => $tipos]);
    }

    /**
     * Modifica os dados de um recurso
     */
    public function edit()
    {
        $form = Input::all();
        $tipo = "Erro";

        $updated = Recurso::find($form['id'])->update(['nome' => $form['nome'], 'tipo_recurso_id' => $form['tipo'], 'descricao' => $form['descricao'], 'status' => $form['status']]);

        if($updated == 1)
        {
            $tipo = "Sucesso";
            $mensagem = "Atualização feita com sucesso!";
        }
        else $mensagem = "Erro no banco de dados.";

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);
        return back();
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
            $deleted = Recurso::find($id)->update(['status' => 0]);
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

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);
        return redirect()->route('showAsset');
    }
}
