<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TipoRecursoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testa a criação de um TipoRecurso
     *
     * @return void
     */
    public function testCriarTipoRecurso()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $rota = route('tiporecurso.create');
        $tipoRecursoNome = "Novo tipo";

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->type($tipoRecursoNome, "nome")
             ->press("Confirmar")
             ->see("Sucesso")
             ->seeInDatabase('tipo_recurso', ["nome" => $tipoRecursoNome]);
    }

    /**
     * Testa a edição de um TipoRecurso
     *
     * @return void
     */
    public function testEditarTipoRecurso()
    {
        $tipoRecurso = factory(App\TipoRecurso::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $rota = route('tiporecurso.edit', $tipoRecurso->id);

        $tipoRecursoNome = "Novo tipo";

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->type($tipoRecursoNome, "nome")
             ->press("Confirmar")
             ->see("Sucesso")
             ->seeInDatabase('tipo_recurso', ["nome" => $tipoRecursoNome]);
    }

    /**
     * Testa a visualização do índice do TipoRecurso
     *
     * @return void
     */
    public function testIndiceTipoRecurso()
    {
        $tipoRecurso = factory(App\TipoRecurso::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $rota = route('tiporecurso.index');

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->see($tipoRecurso->nome);
    }

    /**
     * Testa a exclusão de um TipoRecurso
     *
     * @return void
     */
    public function testExcluirTipoRecurso()
    {
        $tipoRecurso = factory(App\TipoRecurso::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $rota = route('tiporecurso.index');

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->press("excluir_button_" . $tipoRecurso->id)
             ->see("Sucesso")
             ->dontSeeInDatabase('tipo_recurso', ["nome" => $tipoRecurso->nome]);
    }
}
