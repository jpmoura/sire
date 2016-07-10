<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use Session;
use Input;
use Illuminate\Support\Facades\Redirect;
use Log;

class UserController extends Controller
{

  public function addNewUser()
  {
    if(!$this->checkLogin()) return Redirect::route("getLogin");

    if($this->checkPermissions(1)) { // Se é administrador

      $tipo = "Erro";
      $login = Input::get("cpf");
      $checkLogin = DB::table("ldapusers")->where("cpf", $login)->get();

      if(!empty($checkLogin)) {
        Session::flash("mensagem", "Usuário já existe!");
        Session::flash("tipo", $tipo);
        return Redirect::back();
      }
      else { // o login não existe
        $nome = Input::get("nome");
        $email = Input::get("email");
        $nivel = Input::get("nivel");
        $cpf = Input::get("cpf");

        if(Input::get('canAdd') == 1) {
          $id = DB::table("ldapusers")->insert(["nome" => $nome, "cpf" => $cpf, "email" => $email, "nivel" => $nivel]);
          if(isset($id)) {
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

    } // Usuário comum
    else abort(403);
  }

  public function getNewUser()
  {
    if(!$this->checkLogin()) return Redirect::route("getLogin");

    if($this->checkPermissions(1)) {
      $page_title = "<i class='fa fa-user-plus'></i> Cadastrar Usuário";
      $page_description = "Preencha os campos para adicionar um novo usuário ao sistema.";
      Session::put('menu', "addUsuario");
      return View::make('admin.actions.addUser')->with(['page_description' => $page_description, 'page_title' => $page_title]);
    }
    else abort(401);
  }

  public function getUsers()
  {
    if($this->checkLogin()) {
      $usuarios = DB::table('ldapusers')->select()
                                        ->where('nivel', '<>', 0)
                                        ->orderBy("nome", "asc")
                                        ->get();
      $page_title = "<i class='fa fa-users'></i> Usuários cadastrados";
      $page_description = "Lista de todos os usuários cadastrados no sistema ou que já fizeram alguma reserva.";
      Session::put('menu', "viewUsuario");
      return View::make('admin.actions.viewUsers')->with(['usuarios' => $usuarios, 'page_title' => $page_title, 'page_description' => $page_description]);
    }
    else return Redirect::route("getLogin");
  }

  public function getEditUser($cpf)
  {
    //checa se está logado
    if(!$this->checkLogin()) return Redirect::route("getLogin");

    // se não houver permissão, lança erro
    if(!$this->checkPermissions(1)) abort(401);
    else {
      $usuario = DB::table('ldapusers')->select()->where('cpf', $cpf)->first();

      // erro de SQL
      if(!isset($usuario)) abort(404); // tratar erro
      else {
        $page_title = "<i class='fa fa-edit'></i> Editar dados";
        $page_description = "Edição dos dados cadastrais";
        Session::put('menu', "editUsuario");
        return View::make('admin.actions.editUser')->with(['usuario' => $usuario, 'page_title' => $page_title, 'page_description' => $page_description]);
      }
    }
  }

  public function editUser()
  {
    if(!$this->checkLogin()) return Redirect::route("getLogin");

    $tipo = "Erro";
    $form = Input::all();

    if($this->checkPermissions(1)) {
      $updated = DB::table("ldapusers")->where('cpf', $form['cpf'])->update(['nivel' => $form['nivel']]);

      if($updated == 1) {
        $tipo = "Sucesso";
        $mensagem = "Atualização feita com sucesso!";
      }
      else $mensagem = "Erro no banco de dados. Nada foi atualizado.";

      Session::flash("tipo", $tipo);
      Session::flash("mensagem", $mensagem);

      return Redirect::to('/usuarios/editar/' . $form['cpf']);
    }
    else abort(403);
  }

  public function deleteUser()
  {
    if(!$this->checkLogin()) return Redirect::route("getLogin");

    if($this->checkPermissions(1)) {
      $cpf = Input::get("cpf");
      $tipo = "Erro";
      $mensagem = "Mensagem do banco de dados: ";

      try {
        $deleted = DB::table('ldapusers')->where('cpf', $cpf)->update(['nivel' => 0]);
      } catch(\Illuminate\Database\QueryException $ex){
        $deleted = 0;
        $mensagem = $mensagem . $ex->getMessage();
      }

      if($deleted == 1) {
        $tipo = "Sucesso";
        $mensagem = "Usuário removido com sucesso!<br/><span class='text-bold'>OBS.:</span> O usuário ainda existe no banco de dados para que não se perca dados históricos, ele só não terá mais acesso ao sistema.";
      }
      Session::flash("mensagem", $mensagem);
      Session::flash("tipo", $tipo);
      return Redirect::route('viewUsuarios');
    }
    else abort(403);
  }

  public function hexToStr($hex) {
    $string = '';
    for ($i = 0; $i < strlen($hex) - 1; $i+=2) {
      $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
    }
    return $string;
  }

  public function encodePassword($raw) {
    $password = base64_encode($this->hexToStr(md5($raw)));
    return $password;
  }

  public function isPasswordValid($encoded, $raw) {
    $password = base64_encode($this->hexToStr(md5($raw)));
    return $password == $encoded;
  }

  public function persistLdapUser() {

  }

  /**
  * Retorna o nível de privilégio do usuário, caso ele tenha algum
  * senão retorna 0 e o acesso é proibido
  */
  public function permitted($group, $cpf)
  {
    // Procura pelo usuário na tabela ldapusers
    try {
      $user = DB::table("ldapusers")->select("cpf", "nivel")->where('cpf', $cpf)->first();
    } catch(\Illuminate\Database\QueryException $ex){
      Session::flash('message', "Erro durante consulta ao banco de dados.");
    }

    // Se não é NULL, o usuário está persisitno no banco, basta apenas retornar o nível de privelégio
    if(!is_null($user)) return $user->nivel;

     // Senão pode ser ser primeiro acesso, logo é um professor pois usuários especias e administradores devem estar previamente no banco
     // Se pertencer ao grupo do ICEA (714), DECEA (715) ou DEENP - ICEA (716) é um professor do campus e está liberado
    elseif($group == 714 || $group == 715 || $group == 716) {
      // persistir o usuário no banco
      // codigo 4 é para persistir o usuário no banco
      return 4;
    }

    // Se não estiver presente no banco de dados, nem nos grupos do campus do LDAP, então não tem privilégio
    else return 0;
  }

  public function doLogin()
  {
    if($this->checkLogin()) return Redirect::route("home");
    else {
      $ldap = DB::table('ldap')->select()->first();
      $ds = ldap_connect($ldap->server); // Ip servidor ldap
      $bind = ldap_bind($ds, $ldap->user . ',' . $ldap->domain, $ldap->password); // conexão, usuário leitor, senha
      if($bind) {
        $login = Input::get("login");

        // filtrar pelo login, que é o CPF
        $filter = "(" . 'uid' . "=" . $login . ")"; // filtrar pelo login, que é o CPF

        // Atributos a serem recuperados, CPF, Primeiro Nome, Sobrenome. e-mail, grupo, telefones e senha
        $justthese = array('uid', 'cn', 'sn', 'mail', 'OU', 'telephoneNumber', 'userPassword', 'gidNumber');

        // Procurar na conexão LDAP, no dominio dc=ufop,dc=br usando o filtro de CPF e retornando somente as informações desejadas
        $sr = ldap_search($ds, 'dc=ufop,dc=br', $filter, $justthese);

        // Recuperar todas as entradas encontradas, que no caso deve ser só uma
        $entry = ldap_get_entries($ds, $sr);
        if ($entry['count'] > 0) { // Se o número de entradas encontradas for maio que 0, então encontrou o usuário

          // Verificar se a senha informada no login é a mesma no LDAP
          // A senha do LDAP é um md5 da senha bruta do usuário, que depois é convertida em hexadecimal e então codificada em base 64
          // processo da senha: senha bruta => MD5 => Hexadecimal => base64

          // Verifica se o usuário tem permissão de acesso no sistema
          $level = $this->permitted($entry[0]['gidnumber'][0], $entry[0]['uid'][0]);

          if(!$level) {
            // Se ele não tiver, retorna erro
            $mensagem = "Você não tem permissão de acesso ao sistema.";
            $erro = 1;
            $input = "";
          }

          // Se a senha é válida e ele pertence ao grupo do ICEA no LDAP, então está autenticado
          else if($this->isPasswordValid(substr($entry[0]['userpassword'][0], 5), Input::get("senha"))) {
            // Coloca só as primeiras letras de cada palavra em Maiúsculo
            $name = ucwords(strtolower($entry[0]['cn'][0] . ' ' . $entry[0]['sn'][0]));
            $username = explode(" ", $name);
            Session::put("username", $username[0] . ' ' . $username[1]);
            Session::put("id", $entry[0]['uid'][0]);
            Session::put("nome", $name);

            // Se o level tiver código 4, é para persistir no banco
            if($level == 4) {
              $level = 2; // retorna o level para 2 antes da inserção
              $user = DB::table("ldapusers")->insert(['cpf' => Session::get('id'), 'nome' => $name, 'email' => $entry[0]['mail'][0], 'nivel' => $level]);
            }

            Session::put("nivel", $level);
            Log::info("Usuário com ID " . $entry[0]['uid'][0] . " e nome " . $name . " entrou no sistema.");
            return Redirect::route("home");
          }
          else {
            $mensagem = "A senha está incorrreta!";
            $erro = 2;
            $input = Input::get('login');
          }
        }
        else {
          $erro = 1;
          $mensagem = "O usuário não existe";
          $input = "";
        }
        ldap_unbind($ds);
      }
      else {
        $erro = 1;
        $mensagem = "Impossível conectar ao servidor de autenticação";
        $input = "";
      }
      Session::flash("erro", $erro);
      Session::flash("mensagem", $mensagem);
      return Redirect::back()->withInput(["login" => $input]);
    }
  }

  /**
  * Método para retornar uma consulta AJAX para que o administrador possa confirmar
  * os dados do novo usuário que será inserido no banco.
  */
  public function searchPerson() {
    $ldap = DB::table('ldap')->select()->first();
    $ds = ldap_connect($ldap->server); // Ip servidor ldap
    $bind = ldap_bind($ds, $ldap->user . ',' . $ldap->domain, $ldap->password); // conexão, usuário leitor, senha
    if($bind) {
      $login = Input::get("cpf");

      // filtrar pelo login, que é o CPF
      $filter = "(" . 'uid' . "=" . $login . ")"; // filtrar pelo login, que é o CPF

      // Atributos a serem recuperados: Primeiro Nome, Sobrenome, e-mail, grupo
      $justthese = array('cn', 'sn', 'mail', 'OU');

      // Procurar na conexão LDAP, no dominio dc=ufop,dc=br usando o filtro de CPF e retornando somente as informações desejadas
      $sr = ldap_search($ds, 'dc=ufop,dc=br', $filter, $justthese);

      // Recuperar todas as entradas encontradas, que no caso deve ser só uma
      $entry = ldap_get_entries($ds, $sr);
      if ($entry['count'] > 0) { // Se o número de entradas encontradas for maio que 0, então encontrou o usuário
        $name = ucwords(strtolower($entry[0]['cn'][0] . ' ' . $entry[0]['sn'][0]));
        $email = $entry[0]['mail'][0];
        $group = $entry[0]['ou'][0];

        return response()->json(['status' => 'success', 'name' => $name, 'email' => $email, 'group' => $group]);
      }
      else {
        return response()->json(['status' => 'danger', 'msg' => 'Nenhum usuário encontrado com esse CPF.']);
      }
      ldap_unbind($ds);
    }
    else {
      return response()->json(['status' => 'danger', 'msg' => 'Erro de conexão com o servidor LDAP.']);
    }
  }

  public function doLogout()
  {
    if($this->checkLogin()) {
      Log::info("Usuário com ID " . Session::get("id") . " e nome " . Session::get("nome") . " saiu do sistema.");
      Session::flush();
      return Redirect::route("getLogin")->with("mensagem", "Você foi desconectado com sucesso.");
    }
    else return Redirect::route("getLogin");
  }

  public static function checkLogin()
  {
    if(Session::has("id")) return true;
    else return false;
  }

  public static function checkPermissions($nivel)
  {
    if(Session::get("nivel") == $nivel) return true;
    else return false;
  }
}
