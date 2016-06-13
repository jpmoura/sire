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
      $login = Input::get("login");
      $checkLogin = DB::table("tb_usuario")->where("usuLogin", $login)->get();

      if(!empty($checkLogin)) {
        Session::flash("mensagem", "Login já existe!");
        Session::flash("tipo", $tipo);
        return Redirect::back()->withInput(Input::except('login'));
      }
      else { // o login não existe
        $nome = Input::get("nome");
        $email = Input::get("email");
        $senha = Input::get("senha");
        $telefone = Input::get("telefone");
        $celular = Input::get("celular");
        $nivel = Input::get("nivel");

        $id = DB::table("tb_usuario")->insertGetId(["usuNome" => $nome, "usuLogin" => $login, "usuEmail" => $email, "usuTelefone" => $telefone,
                                                    "usuCelular" => $celular, "usuNivel" => $nivel, "usuSenha" => $senha]);

        if(isset($id)) {
          $tipo = "Sucesso";
          $mensagem = "Usuário adicionado com sucesso.";
        }
        else $mensagem = "Falha de SQL ao inserir usuário";

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
      $page_description = "Lista de todos os usuários cadastrados no sistema";
      Session::put('menu', "addUsuario");
      return View::make('admin.actions.addUser')->with(['page_description' => $page_description, 'page_title' => $page_title]);
    }
    else abort(401);
  }

  public function getUsers()
  {
    if($this->checkLogin()) {
      $usuarios = DB::table('tb_usuario')->select('usuId as id', 'usuNome as nome', 'usuTelefone as telefone', 'usuCelular as celular', 'usuLogin as login', 'usuEmail as email')
                                         ->orderBy("usuNome", "asc")
                                         ->get();
      $page_title = "<i class='fa fa-users'></i> Usuários cadastrados";
      $page_description = "Lista de todos os usuários cadastrados no sistema";
      Session::put('menu', "viewUsuario");
      return View::make('admin.actions.viewUsers')->with(['usuarios' => $usuarios, 'page_title' => $page_title, 'page_description' => $page_description]);
    }
    else return Redirect::route("getLogin");
  }

  public function getEditUser($id = null)
  {
    if(!$this->checkLogin()) return Redirect::route("getLogin");

    // pegar o id da sessao, significa que o próprio usuário vai alterar seus dados
    if(is_null($id)) $id = Session::get('id');

    if($id != Session::get('id') && !$this->checkPermissions(1)) abort(401);
    else {
      $usuario = DB::table('tb_usuario')->select('usuId as id', 'usuNome as nome', 'usuTelefone as telefone', 'usuCelular as celular', 'usuLogin as login', 'usuEmail as email', 'usuNivel as nivel')
                                        ->where('usuId', $id)->first();

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

    if($form['id'] == Session::get("id") || $this->checkPermissions(1)) {
      $checkLogin = DB::table("tb_usuario")->where("usuLogin", $form['login'])->get();
      if(count($checkLogin) < 2) {
        $updated = DB::table("tb_usuario")->where('usuId', $form['id'])
                                          ->update(['usuNome' => $form['nome'], 'usuLogin' => $form['login'], 'usuTelefone' => $form['telefone'], 'usuCelular' => $form['celular'],
                                                    'usuEmail' => $form['email'], 'usuNivel' => $form['nivel']]);

        if($updated == 1) {
          $tipo = "Sucesso";
          $mensagem = "Atualização feita com sucesso!";
          if(Session::get("id") == $form["id"]) {
            Session::put("nome", $form['nome']);
            Session::put("nivel", $form["nivel"]);
          }
        }
        else $mensagem = "Erro no banco de dados. Nada foi atualizado";
      }

      else $mensagem = "O login já existe!";

      Session::flash("tipo", $tipo);
      Session::flash("mensagem", $mensagem);
      return Redirect::to('/usuarios/editar/' . $form['id']);

    }
    else abort(403);
  }

  public function deleteUser()
  {
    if(!$this->checkLogin()) return Redirect::route("getLogin");

    if($this->checkPermissions(1)) {
      $id = Input::get("id");
      $tipo = "Erro";
      $mensagem = "Mensagem do banco de dados: ";


      try {
        $deleted = DB::table('tb_usuario')->where('usuId', $id)->delete();
      } catch(\Illuminate\Database\QueryException $ex){
        $deleted = 0;
        $mensagem = $mensagem . $ex->getMessage();
      }

      if($deleted == 1) {
        $tipo = "Sucesso";
        $mensagem = "Usuário removido com sucesso!";
      }
      Session::flash("mensagem", $mensagem);
      Session::flash("tipo", $tipo);
      return Redirect::route('viewUsuarios');
    }
    else abort(403);
  }

  public function doLogin()
  {

    if($this->checkLogin()) return Redirect::route("home");
    else {
      $login = Input::get("login");

      $usuario = DB::table("tb_usuario")->select("usuId")
                                        ->where("usuLogin", $login)
                                        ->first();

      if(isset($usuario)) { // Login existe
        $senha = Input::get("senha");
        $usuario = DB::table("tb_usuario")->select('usuId as id', 'usuNome as nome', 'usuNivel as nivel')
                                          ->where("usuSenha", $senha)
                                          ->where("usuLogin", $login)
                                          ->first();

        if(isset($usuario)) {  // senha está correta
          Session::put("id", $usuario->id);
          Session::put("nome", $usuario->nome);
          Session::put("nivel", $usuario->nivel);
          Log::info("Usuário com ID " . $usuario->id . " e nome " . $usuario->nome . " entrou no sistema.");
          return Redirect::route("home");
        }
        else {
          $erro = 2;
          $mensagem = "A senha está incorreta";
          $input = $login;
        }
      }
      else {
        $erro = 1;
        $mensagem = "O usuário não existe";
        $input = "";
      }
      Session::flash("erro", $erro);
      Session::flash("mensagem", $mensagem);
      return Redirect::back()->withInput(["login" => $input]);
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
