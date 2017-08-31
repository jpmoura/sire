<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BugTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Teste de criação de uma instância do modelo Bug
     *
     * @return void
     */
    public function testCriarBug()
    {
        $rota = route('bug.create');
        $usuario = factory(App\Usuario::class, 'normal')->create();

        $titulo = 'titulo';
        $descricao = 'descricao';

        $this->actingAs($usuario)
             ->visit($rota)
             ->type($titulo, 'title')
             ->type($descricao, 'description')
             ->press("Confirmar");

        //$this->seeInDatabase('bugs', ['titulo' => $titulo, 'descricao' => $descricao]);
        $this->see('Sucesso');
        $this->dontSee('Erro');
    }

    /**
     * Teste de visualização do índice de bugs cadastrados.
     *
     * @return void
     */
    public function testVisualiazarIndiceBugs()
    {
        $rota = route('bug.index');

        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $bug = factory(App\Bug::class)->create();

        // Teste com nível usuário permitido
        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->see("Atualmente existem");
    }

    /**
     * Teste de visualização dos detalhes de um bug.
     *
     * @return void
     */
    public function testVisualizarDetalhesBug()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $bug = factory(App\Bug::class)->create();

        $rota = route('bug.show', $bug->id);

        // Teste com nível usuário permitido
        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->see("Detalhes do bug");
    }

    /**
     * Teste a deleção de uma instância do modelo Bug
     *
     * @return void
     */
    public function testDeletarBug()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $bug = factory(App\Bug::class)->create();

        $rota = route('bug.show', $bug->id);

        // Teste com nível usuário permitido
        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->press('excluir_button_' . $bug->id)
             ->dontSeeInDatabase('bugs', [
                 'usuario_id' => $bug->usuario_id,
                 'titulo' => $bug->titulo,
                 'descricao' => $bug->descricao,
                 'status' => $bug->status,
                 'id' => $bug->id
             ]);

    }
}
