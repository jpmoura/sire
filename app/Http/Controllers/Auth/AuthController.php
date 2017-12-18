<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoginErrorEvent;
use App\Events\LoginFailed;
use App\Events\NewUserCreated;
use App\Http\Requests\LoginRequest;
use App\MeuIceaUser;
use Illuminate\Http\Request;
use App\Usuario;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Encryption\Encrypter;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Crypt;

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
        return view('login');
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
    public function postLogin(LoginRequest $request) {
        $input = $request->all();

        // Retirada dos pontos e hífen do CPF
        $input['username'] = str_replace('.', '', $input['username']);
        $input['username'] = str_replace('-', '', $input['username']);

        // Componentes do corpo da requisição
        $requestBody['user'] = $input['username'];
        $requestBody['password'] = $input['password'];
        $requestBody['attributes'] = ["cpf", "nomecompleto", "email", "id_grupo"]; // Atributos que devem ser retornados em caso autenticação confirmada

        // Chamada de autenticação para a LDAPI
        $httpClient = new Client(['verify' => false]);
        try
        {
            $response = $httpClient->request(config('ldapi.requestMethod'), config('ldapi.authUrl'), [
                "auth" => [config('ldapi.user'), config('ldapi.password'), "Basic"],
                "body" => json_encode($requestBody),
                "headers" => [
                    "Content-type" => "application/json",
                ],
            ]);
        }
        catch (ClientException $ex)
        {
            $credentials['username'] = $input["username"];
            $credentials['password'] = $input['password'];
            event(new LoginFailed($credentials));

            return back()->withErrors(['credentials' => $ex->getResponse()->getBody()->getContents()]);
        }
        catch (RequestException $ex)
        {
            event(new LoginErrorEvent($ex->getMessage()));
            return back()->withErrors(['server' => $ex->getResponse()->getBody()->getContents()]);
        }

        // Se nenhuma excessão foi jogada, então o usuário está autenticado
        $user = Usuario::where('cpf', $input['username'])->first();

        // Se o usuário é NULL então ou ele não é cadastrado no sistema ainda ou não tem permissão
        if(is_null($user))
        {
            // Recupera os atributos retornados pelo servidor de autenticação
            $userData = json_decode($response->getBody()->getContents());

            //Verificar se ele pertence a algum grupo que é permitido de usar o sistema
            if($this->isPermitted($userData->id_grupo))
            { // Se for permitido, então cria-se um novo usuário
                $user = Usuario::create([
                    'cpf' => $userData->cpf,
                    'email' => $userData->email,
                    'nome' => ucwords(strtolower($userData->nomecompleto)),
                    'nivel' => 2,
                    'status' => 1
                ]);

                event(new NewUserCreated($user));
            }
            else return redirect()->route('selectAllocatedAsset'); // Senão redireciona para a rota de seleção de recurso
        }

        // Se o usuário tem status ativo, então realiza-se o login
        if($user->status == 1)
        {
            if(isset($input['remember-me']))  auth()->login($user, true);
            else auth()->login($user);

            return redirect()->intended('/');
        }
        else // Senão retorna para a página de login com mensagem de erro.
        {

            return back()->withErrors(['unauthorized' => 'Você não está mais autorizado a usar o sistema.']);
        }
    }

    /**
     * Gera um token para que o usuário proveniente do portal Meu ICEA consiga realizar o login sem preencher novamente o formulário
     * @param Request $request Requisição com os dados necessários para gerar o token
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function generateMeuIceaToken(Request $request)
    {
        // Cria o decriptador com a chave do Meu ICEA
        $decrypter = new Encrypter(config('meuicea.chave'), config('meuicea.algoritmo'));
        $id = $decrypter->decrypt($request->header('Meu-ICEA')); // decripta a informação

        $meuIceaUser = MeuIceaUser::find($id);

        $user = Usuario::where('cpf', $meuIceaUser->cpf)->first();

        // Se o usuário não existir no sistema
        if(is_null($user))
        {
            // Verifica se ele é permitido a usar o sistema
            if($this->isPermitted($meuIceaUser->id_grupo))
            {
                // Cria o novo usuário se sim
                $user = Usuario::create([
                    'cpf' => $meuIceaUser->cpf,
                    'email' => $meuIceaUser->email,
                    'nome' => ucwords(strtolower($meuIceaUser->nomecompleto)),
                    'nivel' => 2,
                    'status' => 1
                ]);

                event(new NewUserCreated($user)); // Dispara o evento de novo usuário
            }
            else return response('quadro', 200); // Se não for permitido, redireciona para a seleção de recursos para visualizar o quadro de reserva
        }

        // Se o usuário tem status ativo, então realiza-se o login
        if($user->status == 1)
        {
            // Gera um novo token para ser utilizado na autenticação
            $newToken = str_random(32);
            $user->meuicea_token = $newToken;
            $user->save();
            return response($newToken, 200);
        }
        else return response('Você não está mais autorizado a usar o sistem de reserva.', 403); // Senão retorna com erro de não permitido
    }

    public function tokenLogin($token)
    {
        $user = Usuario::where('meuicea_token', $token)->first();

        // Se o token não foi encontrado, ou ele nunca existiu ou já foi consumido o que siginifca um erro de autorização
        if(is_null($user)) abort(430);
        else
        {
            // O token ainda não foi usado e será consumido neste login
            $user->meuicea_token = NULL;
            $user->save();

            auth()->login($user);
            return redirect()->route('home');
        }
    }
}
