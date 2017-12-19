<?php

namespace App\Http\Controllers;

use App\Bug;
use App\Http\Requests\AddBugRequest;
use App\Http\Requests\DeleteBugRequest;
use Input;

class BugController extends Controller
{
    /**
     * Renderiza a view com o formmulário de adição de um novo bug.
     */
    public function create()
    {
        return view('bug.create');
    }

    /**
     * Renderiza uma view com uma lista de todos os bugs.
     * @return mixed
     */
    public function index()
    {
        return view('bug.index')->with(['bugs' => Bug::with('autor')->get()]);
    }

    /**
     * Renderiza uma view com os detalhes de um determinado bug.
     * @param Bug $bug Instância do bug a ser visualizada
     */
    public function show(Bug $bug)
    {
        $bug->load('autor');
        return view('bug.show')->with(['bug' => $bug]);
    }

    /**
     * Adiciona um novo registro de bug ao banco de dados.
     */
    public function store(AddBugRequest $request)
    {
        $tipo = "Erro";
        $form = $request->all();

        try
        {
            Bug::create([
                'usuario_id' => auth()->id(),
                'titulo' => $form['title'],
                'descricao' => $form['description'],
            ]);

            $tipo = "Sucesso";
            $mensagem = "Bug reportado. Obrigado por contribuir para a melhoria do sistema :)";
        }
        catch(\Exception $e)
        {
            $mensagem = 'Falha ao adicionar o bug: ' . $e->getMessage();
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route('home');
    }

    /**
     * Remove o registro do bug no banco de dados.
     */
    public function destroy(Bug $bug)
    {
        $tipo = "Erro";

        try
        {
            $bug->delete();
            $tipo = "Sucesso";
            $mensagem = "Bug foi excluído.";
        }
        catch(\Exception $e)
        {
            $mensagem = "Falha ao apagar bug: " . $e->getMessage();
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route('bug.index');
    }
}
