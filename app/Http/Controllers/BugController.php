<?php

namespace App\Http\Controllers;

use App\Bug;
use Input;

class BugController extends Controller
{
    /**
     * Renderiza a view com o formmulário de adição de um novo bug.
     */
    public function add()
    {
        return view('bug.add');
    }

    /**
     * Renderiza uma view com uma lista de todos os bugs.
     * @return mixed
     */
    public function show()
    {
        return view('bug.show')->with(['bugs' => Bug::with('autor')->get()]);
    }

    /**
     * Renderiza uma view com os detalhes de um determinado bug.
     * @param Bug $bug Instância do bug a ser visualizada
     */
    public function details(Bug $bug)
    {
        $bug->load('autor');
        return view('bug.details')->with(['bug' => $bug]);
    }

    /**
     * Adiciona um novo registro de bug ao banco de dados.
     */
    public function store()
    {
        $tipo = "Erro";
        $form = Input::all();

        $bug = Bug::create([
            'usuario_id' => auth()->id(),
            'titulo' => $form['title'],
            'descricao' => $form['description'],
        ]);

        if(isset($bug))
        {
            $tipo = "Sucesso";
            $mensagem = "Bug reportado. Obrigado por contribuir para a melhoria do sistema :)";
        }
        else $mensagem = "Falha do banco dados.";

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return back();
    }

    /**
     * Remove o registro do bug no banco de dados.
     */
    public function delete()
    {
        $tipo = "Erro";

        $status = Bug::destroy(Input::get('id'));

        if ($status)
        {
            $tipo = "Sucesso";
            $mensagem = "Bug foi excluído.";
        }
        else $mensagem = "Falha do banco dados. O bug não foi excluído.";

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route('showBug');

    }
}
