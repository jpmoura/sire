<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SoftwareTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Teste de criação de um novo fabricante de software
     *
     * @return void
     */
    public function testCriarSoftware()
    {
        $rota = route('software.create');

        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $softwareNome = "Novo software";
        $softwareVersao = "1.0";
        $fabricante = factory(App\FabricanteSoftware::class)->create();

        // Teste com nível usuário permitido
        $this->actingAs($usuarioAdministrador)
            ->visit($rota)
            ->type($softwareNome, "nome")
            ->type($softwareVersao, "versao")
            ->select($fabricante->id, "fabricante")
            ->select(1, "status")
            ->press("Confirmar")
            ->see("Sucesso")
            ->seeInDatabase('softwares', [
                'nome' => $softwareNome,
                'versao' => $softwareVersao,
                'fabricante_software_id' => $fabricante->id,
                'status' => 1
                ]);
    }

    /**
     * Teste de edição de uma instância de Software
     *
     * @return void
     */
    public function testEditarSoftware()
    {
        $software = factory(App\Software::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();

        $rota = route('software.edit', $software->id);

        $novoNome = "Editado";
        $novaVersao = "Editado";

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->type($novoNome, "nome")
             ->type($novaVersao, "versao")
             ->select(0, "status")
             ->press("Confirmar")
             ->see("Sucesso")
             ->seeInDatabase('softwares', [
                 'nome' => $novoNome,
                 'versao' => $novaVersao,
                 'fabricante_software_id' => $software->fabricante_software_id,
                 'status' => 0
             ]);
    }

    /**
     * Teste de visualização do índice de Software
     *
     * @return void
     */
    public function testIndiceSoftware()
    {
        $software = factory(App\Software::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();

        $rota = route('software.index');

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->see($software->nome);
    }

    /**
     * Teste de exclusão de instância de Software
     *
     * @return void
     */
    public function testExcluirSoftware()
    {
        $software = factory(App\Software::class)->create();
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();

        $rota = route('software.index');

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->press("excluir_button_" . $software->id)
             ->see("Sucesso")
             ->dontSeeInDatabase('softwares', [
                 'nome' => $software->nome,
                 'versao' => $software->versao,
                 'fabricante_software_id' => $software->fabricante_software_id,
                 'status' => $software->status
             ]);
    }
}
