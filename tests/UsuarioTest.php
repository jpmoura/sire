<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsuarioTest extends TestCase
{

    use DatabaseTransactions;

    public function testLogin()
    {
        $rota = url('login');
        $usuario = factory(App\Usuario::class)->create();

        $this->visit($rota)
            ->type($usuario->email, 'email')
            ->type('senha', 'password')
            ->press('Entrar')
            ->see('Painel de Controle');


        $usuario->status = 0;
        $usuario->save();

        $this->visit(url('logout'))
            ->visit($rota)
            ->type($usuario->email, 'email')
            ->type('senha', 'password')
            ->press('Entrar')
            ->see('Erro');
    }

    public function testCreate()
    {
        $rota = route('usuario.create');
        $usuarioAdministador = factory(App\Usuario::class, 'admin')->create();

        $nome = 'Nome teste';
        $email = 'email@teste.com';
        $senha = str_random(10);

        $this->actingAs($usuarioAdministador)
            ->visit($rota)
            ->type($nome, 'nome')
            ->type($email, 'email')
            ->type($senha, 'password')
            ->type($senha, 'password_confirmation')
            ->select('1', 'nivel')
            ->press('Confirmar')
            ->see('Sucesso')
            ->seeInDatabase('usuarios', [
                'nome' => $nome,
                'email' => $email,
                'nivel' => 1,
            ]);
    }

    public function testUpdate()
    {
        $usuarioAdministador = factory(App\Usuario::class, 'admin')->create();
        $usuarioNormal = factory(App\Usuario::class, 'normal')->create();

        $rota = route('usuario.edit', $usuarioNormal);

        $nome = 'Nome teste';
        $email = 'email@teste.com';

        $this->actingAs($usuarioAdministador)
            ->visit($rota)
            ->type($nome, 'nome')
            ->type($email, 'email')
            ->select('3', 'nivel')
            ->select('0', 'status')
            ->press('Confirmar')
            ->see('Sucesso')
            ->seeInDatabase('usuarios', [
                'nome' => $nome,
                'email' => $email,
                'status' => 0,
                'nivel' => 3,
            ]);
    }

    public function testDelete()
    {
        $usuarioAdministador = factory(App\Usuario::class, 'admin')->create();
        $usuarioNormal = factory(App\Usuario::class, 'normal')->create();

        $rota = route('usuario.index', $usuarioNormal);

        $this->actingAs($usuarioAdministador)
            ->visit($rota)
            ->press('Excluir')
            ->see('Sucesso')
            ->seePageIs(route('usuario.index'))
            ->seeInDatabase('usuarios', [
                'status' => 0,
            ]);
    }
}
