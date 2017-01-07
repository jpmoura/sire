<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Session;
use Input;
use Illuminate\Support\Facades\Redirect;
use App\Bug;

class BugController extends Controller
{
    /**
     * Renderiza a view com o formmulário de adição de um novo bug.
     */
    public function add()
    {
        return View::make('bug.add');
    }

    /**
     * Renderiza uma view com uma lista de todos os bugs.
     * @return mixed
     */
    public function show()
    {
        $bugs = DB::table('bugs')->join('ldapusers', 'cpf', '=', 'user')->select('title', 'bugs.id', 'nome')->get();
        return View::make('bug.show')->with(['bugs' => $bugs]);

    }

    /**
     * Renderiza uma view com os detalhes de um determinado bug.
     * @param $id ID do bug
     */
    public function details($id)
    {
        $bug = DB::table('bugs')->join('ldapusers', 'cpf', '=', 'user')->select('title', 'bugs.id', 'nome', 'description', 'email')->where('bugs.id', $id)->first();
        return View::make('bug.details')->with(['bug' => $bug]);
    }

    /**
     * Adiciona um novo registro de bug ao banco de dados.
     */
    public function store()
    {
        $tipo = "Erro";
        $form = Input::all();
        $bug = Bug::create(Input::all());

        if(isset($bug))
        {
            $tipo = "Sucesso";
            $mensagem = "Bug reportado. Obrigado por contribuir para a melhoria do sistema :)";
        }
        else $mensagem = "Falha do banco dados.";

        Session::flash("mensagem", $mensagem);
        Session::flash("tipo", $tipo);

        return Redirect::back();
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

        Session::flash("mensagem", $mensagem);
        Session::flash("tipo", $tipo);

        return Redirect::route('showBug');

    }
}
