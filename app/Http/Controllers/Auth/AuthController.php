<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoginFailed;
use App\Events\NewUserCreated;
use App\User;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Input;
use Session;
use View;
use Auth;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Event;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    //protected $redirectTo = '/';
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Renderiza a view de login
     */
    public function getLogin() {
        return View::make('login');
    }

    /**
     * Determina se um usuário é capaz de usar o sistema ou não baseado no seu grupo.
     * @param $group ID do grupo o qual o usuário pertence
     * @return bool True se é autorizado a usar e False caso contrário
     */
    private function isPermitted($group)
    {
        $permitted = false;

        // Se pertencer à algum grupo vinculado ao campus, está liberado
        switch ($group) {
            case 712: // Biblioteca ICEA
            case 714: // ICEA
            case 715: // DECEA
            case 716: // DEENP
            case 7126: // DECOM - Ouro Preto
            case 71130: // DECSI
            case 71481: // DEELT
                $permitted = true;
                break;
        }

        return $permitted;
    }

    /**
     * Realiza o processo de login de usuário.
     */
    public function postLogin() {
        $input = Input::all();

        $ldapi_user = env('LDAPI_USER', 'test');
        $ldapi_password = env('LDAPI_PASSWORD', 'test');

        // Componentes do corpo da requisição
        $requestBody['user'] = $input['username'];
        $requestBody['password'] = $input['password'];
        $requestBody['attributes'] = ["cpf", "nomecompleto", "email", "id_grupo"]; // Atributos que devem ser retornados em caso autenticação confirmada

        // Chamada de autenticação para a LDAPI
        $httpClient = new Client();
        try
        {
            $response = $httpClient->request("POST", "http://200.239.152.5/ldapi/auth", [
                "auth" => [$ldapi_user, $ldapi_password, "Basic"],
                "body" => json_encode($requestBody),
                "headers" => [
                    "Content-type" => "application/json",
                ],
            ]);
        } catch (ClientException $ex) {
            $credentials['username'] = $input["username"];
            $credentials['password'] = $input['password'];
            Event::fire(new LoginFailed($credentials));

            session()->flash('erro', 1);
            session()->flash('mensagem', $ex->getResponse()->getBody()->getContents());
            return redirect()->back();
        }
        catch (RequestException $ex) {
            session()->flash('mensagem', $ex->getResponse()->getBody()->getContents());
            return redirect()->back();
        }

        // Se nenhuma excessão foi jogada, então o usuário está autenticado
        $user = User::where('cpf', $input['username'])->first();

        // Se o usuário é NULL então ou ele não é cadastrado no sistema ainda ou não tem permissão
        if(is_null($user))
        {
            // Recupera os atributos retornados pelo servidor de autenticação
            $userData = json_decode($response->getBody()->getContents());

            //Verificar se ele pertence a algum grupo que é permitido de usar o sistema
            if($this->isPermitted($userData->id_grupo))
            { // Se for permitido, então cria-se um novo usuário
                $user = User::create([
                    'cpf' => $userData->cpf,
                    'email' => $userData->email,
                    'nome' => $userData->nomecompleto,
                    'nivel' => 2,
                    'status' => 1
                ]);

                Event::fire(new NewUserCreated($user));
            }
            else return redirect()->route('selectAllocatedAsset'); // Senão redireciona para a rota de seleção de recurso
        }

        // Se o usuário tem status ativo, então realiza-se o login
        if($user->status == 1)
        {
            if(isset($input['remember-me']))  Auth::login($user, true);
            else Auth::login($user);

            return redirect()->intended('/');
        }
        else // Senão retorna para a página de login com mensagem de erro.
        {
            Session::flash('erro', 1);
            Session::flash('mensagem', 'Você não está mais autorizado a usar o sistema.');
            return redirect()->back();
        }
    }
}
