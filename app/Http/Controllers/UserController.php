<?php

namespace App\Http\Controllers;

use Event;
use App\Events\NewUserCreated;
use App\Events\UserDeleted;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use View;
use DB;
use Session;
use Input;
use Illuminate\Support\Facades\Redirect;
use Log;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UserController extends Controller
{
    /**
     * Cria uma nova instância de usuário no banco de dados.
     */
    public function store()
    {
        $tipo = "Erro";
        $login = Input::get("cpf");
        $checkLogin = User::where('cpf', $login)->first();

        if(!is_null($checkLogin))
        {
            Session::flash("mensagem", "Usuário já existe!");
            Session::flash("tipo", $tipo);
            return Redirect::back();
        }
        else { // o login não existe

            if(Input::get('canAdd') == 1)
            {
                $user = new User();
                $user->cpf = Input::get('cpf');
                $user->nivel = Input::get('nivel');
                $user->nome = ucwords(strtolower(Input::get('nome'))); // Mantém somente a primeira letra em maiúsculo
                $user->email = Input::get('email');
                $user->status = 1;
                $user->save();

                Event::fire(new NewUserCreated($user)); // dispara evento de novo usuário criado

                if(isset($user))
                {
                    $tipo = "Sucesso";
                    $mensagem = "Usuário adicionado com sucesso.";
                }
                else $mensagem = "Falha de SQL ao inserir usuário";
            }
            else $mensagem = "Não é possível inserir um usuário que não esteja cadastrado no LDAP.";

            Session::flash("mensagem", $mensagem);
            Session::flash("tipo", $tipo);

            return Redirect::back();
        }
    }

    /**
     * Exibe o formulário para adição de um novo usuário ao sistema.
     */
    public function add()
    {
        return View::make('user.add');
    }

    /**
     * Renderiza a view que mostra todos os usuários que são ativos (status === 1)
     */
    public function show()
    {
        $usuarios = User::orderBy('nome', 'asc')->get();
        return View::make('user.show')->with(['usuarios' => $usuarios]);
    }

    /**
     * Renderiza a página de edição de  usuários contendos as informações atuais do mesmo
     * @param $cpf CPF do usuário
     */
    public function details($cpf)
    {
        $usuario = User::where('cpf', $cpf)->first();
        return View::make('user.edit')->with(['usuario' => $usuario]);
    }

    /**
     * Realiza a atualização dos dados do usuário.
     */
    public function edit()
    {
        $tipo = "Erro";
        $form = Input::all();

        $updated = User::where('cpf', $form['cpf'])->update(['nivel' => $form['nivel'], 'status' => $form['status']]);

        if($updated == 1) {
            $tipo = "Sucesso";
            $mensagem = "Atualização feita com sucesso!";
        }
        else $mensagem = "Erro no banco de dados. Nada foi atualizado.";

        Session::flash("tipo", $tipo);
        Session::flash("mensagem", $mensagem);

        return Redirect::back();
    }

    /**
     * Define um usuário que não será mais passível de usar o sistema. O usuário é mantido no banco para realizar as
     * referências hist''oricas de outras alocações.
     */
    public function delete()
    {
        $cpf = Input::get("cpf");
        $tipo = "Erro";
        $mensagem = "Ação não realizada! ";

        try {
            $deleted = User::where('cpf', $cpf)->update(['status' => 0]);
        } catch(\Illuminate\Database\QueryException $ex){
            $deleted = 0;
            $mensagem .= $ex->getMessage();
        }

        if($deleted == 1) {
            Event::fire(new UserDeleted(User::where("cpf", $cpf)->first()));
            $tipo = "Sucesso";
            $mensagem = "Usuário removido com sucesso! OBS.: O usuário ainda existe no banco de dados para que não se perca dados históricos, ele só não terá mais acesso ao sistema.";
        }

        Session::flash("mensagem", $mensagem);
        Session::flash("tipo", $tipo);
        return Redirect::route('showUser');
    }

    /**
     * Método para retornar uma consulta AJAX para que o administrador possa confirmar
     * os dados do novo usuário que será inserido no banco.
     */
    public function searchPerson() {

        $ldapi_user = env('LDAPI_USER', 'test');
        $ldapi_password = env('LDAPI_PASSWORD', 'test');

        // Componentes do corpo da requisição
        $requestBody['baseConnector'] = "and";
        $requestBody['attributes'] = ["cpf", "nomecompleto", "email", "grupo"]; // Atributos que devem ser retornados em caso autenticação confirmada
        $requestBody['searchBase'] = "ou=People,dc=ufop,dc=br";
        $requestBody['filters'][0] = ["cpf" => ["equals", Input::get('cpf')]];

        // Chamada de autenticação para a LDAPI
        $httpClient = new Client();
        try
        {
            $response = $httpClient->request(Config::get('ldapi.requestMethod'), Config::get('ldapi.searchUrl'), [
                "auth" => [$ldapi_user, $ldapi_password, "Basic"],
                "body" => json_encode($requestBody),
                "headers" => [
                    "Content-type" => "application/json",
                ],
            ]);
        } catch (RequestException $ex) {
            // TODO log do erro
            return response()->json(['status' => 'danger', 'msg' => 'Erro de conexão com o servidor LDAP.']);
        }

        $result = json_decode($response->getBody()->getContents(), true);
        if($result['count'] != 0)
        {
            $name = $result['result'][0]["nomecompleto"];
            $email = $result['result'][0]["email"];
            $group = $result['result'][0]["grupo"];

            return response()->json(['status' => 'success', 'name' => $name, 'email' => $email, 'group' => $group]);
        }
        else return response()->json(['status' => 'danger', 'msg' => 'Nenhum usuário encontrado com esse CPF.']);
    }
}
