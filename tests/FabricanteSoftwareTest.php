<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FabricanteSoftwareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Teste de criação de um novo fabricante de software
     *
     * @return void
     */
    public function testCriarFabricante()
    {
        $rota = route('fabricante.create');

        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $fabricanteNome = "Novo fabricante";

        // Teste com nível usuário permitido
        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->type($fabricanteNome, "nome")
             ->press("Confirmar")
             ->see("Sucesso")
             ->seeInDatabase('fabricante_softwares', ['nome' => $fabricanteNome]);
    }

    /**
     * Tesde de edição de uma instância FabricanteSoftware
     *
     * @return void
     */
    public function testEditarFabricante()
    {
        $fabricante = factory(App\FabricanteSoftware::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $novoNome = "Novo nome";

        $rota = route('fabricante.edit', $fabricante->id);

        // Teste com nível usuário permitido
        $this->actingAs($usuarioAdministrador)
            ->visit($rota)
            ->type($novoNome, "nome")
            ->press("Confirmar")
            ->see("Sucesso")
            ->seeInDatabase('fabricante_softwares', ['nome' => $novoNome]);
    }

    /**
     * Teste de visualização de índice de FabricanteSoftware
     *
     * @return void
     */
    public function testIndiceFabricante()
    {
        $rota = route('fabricante.index');
        $fabricante = factory(App\FabricanteSoftware::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();

        // Teste com nível usuário permitido
        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->see($fabricante->nome);
    }

    /**
     * Teste de deleção de uma instância FabricanteSoftware
     *
     * @return void
     */
    public function testDeletarFabricante()
    {
        $rota = route('fabricante.index');
        $fabricante = factory(App\FabricanteSoftware::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();

        // Teste com nível usuário permitido
        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->press('excluir_button_' . $fabricante->id)
             ->dontSeeInDatabase('fabricante_softwares', ['nome' => $fabricante->nome]);
    }

}
