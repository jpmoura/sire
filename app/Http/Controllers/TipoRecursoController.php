<?php

namespace App\Http\Controllers;

use App\TipoRecurso;
use Illuminate\Http\Request;

use App\Http\Requests;

class TipoRecursoController extends Controller
{
    /**
     * Renderiza a view com a lista de todos os tipos de recursos cadastrados.
     */
    public function index()
    {
        return view('tiporecurso.index')->with('tipos', TipoRecurso::all());
    }

    /**
     * Renderiza a view com o formulário para criação de um novo tipo de recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tiporecurso.create');
    }

    /**
     * Aramzena uma instância de TipoRecurso na base de dados
     *
     * @param Requests\CreateTipoRecursoRequest $request Requisição com os campos do formulário já validados.
     * @return \Illuminate\Http\RedirectResponse Rota de índice de tipos de recursos
     */
    public function store(Requests\CreateTipoRecursoRequest $request)
    {
        try
        {
            TipoRecurso::create(['nome' => $request->get('nome')]);
            $tipo = 'Sucesso';
            $mensagem = 'Tipo adicionado com sucesso.';
        }
        catch (\Exception $e)
        {
            $tipo = 'Erro';
            $mensagem = 'Falha ao criar novo tipo de recurso: ' . $e->getMessage();
        }

        session()->flash('tipo', $tipo);
        session()->flash('mensagem', $mensagem);

        return redirect()->route('tiporecurso.index');
    }

    /**
     * Renderiza view com o formulário de edição de uma instância de TipoRecurso
     *
     * @param TipoRecurso $tipoRecurso Instância a ser editada
     */
    public function edit(TipoRecurso $tipoRecurso)
    {
        return view('tiporecurso.edit')->with('tipo', $tipoRecurso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\EditTipoRecursoRequest $request, TipoRecurso $tipoRecurso)
    {
        try
        {
            $tipoRecurso->update(['nome' => $request->get('nome')]);
            $tipo = 'Sucesso';
            $mensagem = 'Tipo atualizado com sucesso.';
        }
        catch (\Exception $e)
        {
            $tipo = 'Erro';
            $mensagem = 'Falha ao atualizar tipo de recurso: ' . $e->getMessage();
        }

        session()->flash('tipo', $tipo);
        session()->flash('mensagem', $mensagem);

        return redirect()->route('tiporecurso.index');
    }

    /**
     * Remove do banco de dados uma instância de TipoRecurso
     *
     * @param TipoRecurso $tipoRecurso Instância a ser removida da base de dados
     * @return \Illuminate\Http\RedirectResponse Rota de índice dos tipos
     */
    public function destroy(TipoRecurso $tipoRecurso)
    {
        try
        {
            $tipoRecurso->delete();
            $tipo = 'Sucesso';
            $mensagem = 'Tipo removido com sucesso.';
        }
        catch (\Exception $e)
        {
            $tipo = 'Erro';
            $mensagem = 'Falha ao remover tipo de recurso: ' . $e->getMessage();
        }

        session()->flash('tipo', $tipo);
        session()->flash('mensagem', $mensagem);

        return redirect()->route('tiporecurso.index');
    }
}
