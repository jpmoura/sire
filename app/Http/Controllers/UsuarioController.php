<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Events\NewUserCreated;
use App\Events\UserDeleted;
use Illuminate\Support\Facades\Config;
use Input;
use Illuminate\Support\Facades\Redirect;
use Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UsuarioController extends Controller
{
    /**
     * Cria uma nova instância de usuário no banco de dados.
     */
    public function store()
    {
        $tipo = "Erro";
        $login = Input::get("cpf");
        $checkLogin = Usuario::where('cpf', $login)->first();

        if(!is_null($checkLogin))
        {
            session()->flash("mensagem", "Usuário já existe!");
            session()->flash("tipo", $tipo);
            return back();
        }
        else { // o login não existe

            if(Input::get('canAdd') == 1)
            {
                $usuario = Usuario::create([
                    'cpf' => Input::get('cpf'),
                    'nivel' => Input::get('nivel'),
                    'nome' => ucwords(strtolower(Input::get('nome'))),
                    'email' => Input::get('email'),
                    'status' => 1,
                ]);

                event(new NewUserCreated($usuario)); // dispara evento de novo usuário criado

                if(isset($usuario))
                {
                    $tipo = "Sucesso";
                    $mensagem = "Usuário adicionado com sucesso.";
                }
                else $mensagem = "Falha de SQL ao inserir usuário";
            }
            else $mensagem = "Não é possível inserir um usuário que não esteja cadastrado no LDAP.";

            session()->flash("mensagem", $mensagem);
            session()->flash("tipo", $tipo);

            return back();
        }
    }

    /**
     * Exibe o formulário para adição de um novo usuário ao sistema.
     */
    public function add()
    {
        return view('usuario.add');
    }

    /**
     * Renderiza a view que mostra todos os usuários que são ativos (status === 1)
     */
    public function show()
    {
        $usuarios = Usuario::all()->sortBy('nome');
        return view('usuario.show')->with(['usuarios' => $usuarios]);
    }

    /**
     * Renderiza a página de edição de  usuários contendos as informações atuais do mesmo
     * @param string $cpf CPF do usuário
     */
    public function details($cpf)
    {
        $usuario = Usuario::where('cpf', $cpf)->first();
        return view('usuario.edit')->with(['usuario' => $usuario]);
    }

    /**
     * Realiza a atualização dos dados do usuário.
     */
    public function edit()
    {
        $tipo = "Erro";
        $form = Input::all();

        $updated = Usuario::where('cpf', $form['cpf'])->update(['nivel' => $form['nivel'], 'status' => $form['status']]);

        if($updated == 1) {
            $tipo = "Sucesso";
            $mensagem = "Atualização feita com sucesso!";
        }
        else $mensagem = "Erro no banco de dados. Nada foi atualizado.";

        session()->flash("tipo", $tipo);
        session()->flash("mensagem", $mensagem);

        return back();
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
            $deleted = Usuario::where('cpf', $cpf)->update(['status' => 0]);
        } catch(\Illuminate\Database\QueryException $ex){
            $deleted = 0;
            $mensagem .= $ex->getMessage();
        }

        if($deleted == 1) {
            event(new UserDeleted(Usuario::where("cpf", $cpf)->first()));
            $tipo = "Sucesso";
            $mensagem = "Usuário removido com sucesso! OBS.: O usuário ainda existe no banco de dados para que não se perca dados históricos, ele só não terá mais acesso ao sistema.";
        }

        session()->flash("mensagem", $mensagem);
        session()->flash("tipo", $tipo);

        return redirect()->route('showUser');
    }

    /**
     * Método para retornar uma consulta AJAX para que o administrador possa confirmar
     * os dados do novo usuário que será inserido no banco.
     */
    public function searchPerson() {

        // Componentes do corpo da requisição
        $requestBody['baseConnector'] = "and";
        $requestBody['attributes'] = ["cpf", "nomecompleto", "email", "grupo"]; // Atributos que devem ser retornados em caso autenticação confirmada
        $requestBody['searchBase'] = "ou=People,dc=ufop,dc=br";
        $requestBody['filters'][0] = ["cpf" => ["equals", Input::get('cpf')]];

        // Chamada de autenticação para a LDAPI
        $httpClient = new Client(['verify' => false]);
        try
        {
            $response = $httpClient->request(config('ldapi.requestMethod'), config('ldapi.searchUrl'), [
                "auth" => [config('ldapi.user'), config('ldapi.password'), "Basic"],
                "body" => json_encode($requestBody),
                "headers" => [
                    "Content-type" => "application/json",
                ],
            ]);
        }
        catch (RequestException $ex)
        {
            \Illuminate\Support\Facades\Log::error('Erro na busca de usuário.', ['erro' => $ex->getMessage()]);
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
