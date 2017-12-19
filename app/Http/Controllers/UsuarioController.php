<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsuarioRequest;
use App\Http\Requests\DeleteUsuarioRequest;
use App\Http\Requests\EditUsuarioRequest;
use App\Usuario;
use App\Events\NewUserCreated;
use App\Events\UserDeleted;
use Illuminate\Http\Request;
use Log;

class UsuarioController extends Controller
{
    /**
     * @param CreateUsuarioRequest $request Requisição com os campos do formulário validados
     * @return \Illuminate\Http\RedirectResponse Página de índice com mensagem de sucesso ou fracasso
     */
    public function store(CreateUsuarioRequest $request)
    {
        $tipo = "Erro";

        try
        {
            $usuario = Usuario::create([
                'nome' => $request->get('nome'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'nivel' => $request->get('nivel')
            ]);
            event(new NewUserCreated($usuario)); // dispara evento de novo usuário criado
            $tipo = "Sucesso";
            $mensagem = "Usuário adicionado com sucesso.";
        }
        catch (\Exception $e)
        {
            $mensagem = "Falha de SQL ao inserir usuário. Mensagem do banco: " . $e->getMessage();
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route('usuario.index');
    }

    /**
     * Exibe o formulário para adição de um novo usuário ao sistema.
     */
    public function create()
    {
        return view('usuario.create');
    }

    /**
     * Renderiza a view que mostra todos os usuários que são ativos (status === 1)
     */
    public function index()
    {
        $usuarios = Usuario::all()->sortBy('nome');
        return view('usuario.index')->with(['usuarios' => $usuarios]);
    }

    /**
     * Renderiza a página de edição de  usuários contendos as informações atuais do mesmo
     * @param Usuario Instância de usuário a ser editada
     */
    public function edit($usuario)
    {
        return view('usuario.edit')->with(['usuario' => $usuario]);
    }

    /**
     * @param EditUsuarioRequest $request Requisisão com os campos do formulário validados
     * @return \Illuminate\Http\RedirectResponse Página anterior com mensagem de sucesso ou erro
     */
    public function update(EditUsuarioRequest $request)
    {
        $tipo = "Erro";

        try
        {
            $campos = $request->only(['nome', 'email', 'status', 'nivel']);
            if(!is_null($request->get('password'))) array_add($campos, 'password', bcrypt($request->get('password')));

            Usuario::where('id', $request->get('id'))->update($campos);

            $tipo = "Sucesso";
            $mensagem = "Atualização concluída!";
        }
        catch(\Exception $e)
        {
            $mensagem = "Erro durante a atualização dos dados. Mensagem do banco: " . $e->getMessage();
        }

        session()->flash("tipo", $tipo);
        session()->flash("mensagem", $mensagem);

        return back();
    }

    /**
     * Define um usuário que não será mais passível de usar o sistema. O usuário é mantido no banco para realizar as
     * referências históricas de outras alocações.
     */
    public function delete(DeleteUsuarioRequest $request)
    {
        $id = $request->get("id");
        $tipo = "Erro";
        $mensagem = "Usuário não foi removido! Mensagem do banco: ";

        try
        {
            Usuario::where('id', $id)->update(['status' => 0]);

            event(new UserDeleted(Usuario::where("id", $id)->first()));

            $tipo = "Sucesso";
            $mensagem = "Usuário removido com sucesso! OBS.: O usuário ainda existe no banco de dados para que não se
            perca dados históricos, ele só não terá mais acesso ao sistema.";
        }
        catch(\Exception $ex)
        {
            $mensagem .= $ex->getMessage();
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route('usuario.index');
    }
}
