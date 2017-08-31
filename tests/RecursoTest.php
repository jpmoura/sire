<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecursoTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Testa a criação de um Recurso
     *
     * @return void
     */
    public function testCriarRecurso()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $tipoRecurso = factory(App\TipoRecurso::class)->create();
        $rota = route('recurso.create');
        $recursoNome = "Novo recurso";
        $recursoDescricao = "Nova descricao";

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->type($recursoNome, "nome")
             ->type($recursoDescricao, "descricao")
             ->select(1, "status")
             ->select($tipoRecurso->id, "tipo")
             ->press("Confirmar")
             ->see("Sucesso")
             ->seeInDatabase('recursos', [
                 'nome' => $recursoNome,
                 'descricao' => $recursoDescricao,
                 'status' => 1,
                 'tipo_recurso_id' => $tipoRecurso->id,
                 ]);

        $this->assertTrue(true);
    }

    /**
     * Testa a edição de um Recurso
     *
     * @return void
     */
    public function testEditarRecurso()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $recurso = factory(App\Recurso::class)->create();
        $rota = route('recurso.edit', $recurso->id);

        $novoNome = "Nome editado";
        $novaDescricao = "Nova descricao";
        $novoTipoRecurso = factory(App\TipoRecurso::class)->create();


        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->type($novoNome, "nome")
             ->type($novaDescricao, "descricao")
             ->select(0, "status")
             ->select($novoTipoRecurso->id, "tipo")
             ->press("Confirmar")
             ->see("Sucesso")
             ->seeInDatabase('recursos', [
                 'nome' => $novoNome,
                 'descricao' => $novaDescricao,
                 'status' => 0,
                 'tipo_recurso_id' => $novoTipoRecurso->id,
             ]);
    }

    /**
     * Teste de visualização do índice de Recurso
     *
     * @return void
     */
    public function testIndiceRecurso()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $recurso = factory(App\Recurso::class)->create();
        $rota = route('recurso.index');

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->see($recurso->nome);
    }

    /**
     * Testa a exclusão de uma instância de Recurso
     *
     * @return void
     */
    public function testExcluirRecurso()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $recurso = factory(App\Recurso::class)->create();
        $rota = route('recurso.index');

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->press("excluir_button_" . $recurso->id)
             ->see("Sucesso")
             ->dontSeeInDatabase('recursos', [
                 'tipo_recurso_id' => $recurso->tipo_recurso_id,
                 'nome' => $recurso->nome,
                 'descricao' => $recurso->descricao,
                 'status' => $recurso->status,
             ]);
    }
}
