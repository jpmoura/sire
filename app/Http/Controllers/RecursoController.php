<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRecursoRequest;
use App\Http\Requests\DeleteRecursoRequest;
use App\Http\Requests\EditRecursoRequest;
use App\Recurso;
use Log;
use App\TipoRecurso;

class RecursoController extends Controller
{
    /**
     * Renderiza uma view com o formulário para adição de um novo recurso.
     */
    public function create()
    {
        return view('recurso.create')->with(['tipos' => TipoRecurso::all()]);
    }

    /**
     * Renderiza uma view contendo a lista de todos os recursos cadastrados.
     */
    public function index()
    {
        $recursos = Recurso::with('tipo')->get()->sortBy('nome');
        return view('recurso.index')->with(['recursos' => $recursos]);
    }

    /**
     * Adiciona um novo recurso ao sistema
     */
    public function store(AddRecursoRequest $request)
    {
        $tipo = "Erro";
        $form = $request->all();

        try
        {
            Recurso::create([
                'tipo_recurso_id' => $form['tipo'],
                'nome' => $form['nome'],
                'descricao' => $form['descricao'],
                'status' => $form['status']
            ]);

            $tipo = "Sucesso";
            $mensagem = "Recurso adicionado com sucesso.";
        }
        catch(\Exception $ex)
        {
            $mensagem = "Falha ao adicionar novo recurso: " . $ex->getMessage();
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route("recurso.index");
    }

    /**
     * Renderiza uma view com um formulário de edição dos dados de um recurso.
     * @param Recurso $recurso Instância do recurso a ser editada
     */
    public function edit(Recurso $recurso)
    {
        $tipos = TipoRecurso::all();
        return view('recurso.edit')->with(['recurso' => $recurso, 'tipos' => $tipos]);
    }

    /**
     * @param EditRecursoRequest $request Requisição com os campos do formulário validados
     * @param Recurso $recurso Instância a ser atualizada
     */
    public function update(EditRecursoRequest $request, Recurso $recurso)
    {
        $form = $request->all();
        $tipo = "Erro";

        try
        {
            $recurso->update([
                'nome' => $form['nome'],
                'tipo_recurso_id' => $form['tipo'],
                'descricao' => $form['descricao'],
                'status' => $form['status']
            ]);

            $tipo = "Sucesso";
            $mensagem = "Atualização feita com sucesso!";
        }
        catch(\Exception $e)
        {
            $mensagem = "Erro durante a atualização do recurso: " . $e->getMessage();
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return back();
    }

    /**
     * Modifica o status de um recurso para inativo. Não pode ser removido do banco para não se perder as referências históricas.
     */
    public function destroy(Recurso $recurso)
    {
        $tipo = "Erro";
        $mensagem = "Ação não executada! ";

        try
        {
            $recurso->update(['status' => 0]);
            $tipo = "Sucesso";
            $mensagem = "Recurso removido com sucesso! Ele ainda existe no banco de dados mas não poderá ser reservado por ninguém.";
        }
        catch(\Illuminate\Database\QueryException $ex)
        {
            $mensagem .= $ex->getMessage();
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route('recurso.index');
    }
}
