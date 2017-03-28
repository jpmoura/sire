<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FabricanteSoftwareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Teste de inserção de uma instância.
     */
    public function testInsert()
    {
        $fabricante = \App\FabricanteSoftware::create([
            'nome' => 'Fabricante teste'
        ]);

        $this->seeInDatabase('fabricante_softwares', ['nome' => 'Fabricante teste']);
    }

    /**
     * Teste de atualização de uma instância
     */
    public function testUpdate()
    {
        $fabricante = \App\FabricanteSoftware::create([
            'nome' => 'Fabricante teste'
        ]);

        $fabricante->update([
            'nome' => 'Alterado',
        ]);

        $this->seeInDatabase('fabricante_softwares', ['nome' => 'alterado']);
    }

    /**
     * Teste de remoção de uma instância
     */
    public function testRemove()
    {
        $fabricante = \App\FabricanteSoftware::create([
            'nome' => 'Fabricante teste'
        ]);

        $this->seeInDatabase('fabricante_softwares', ['nome' => 'Fabricante teste']);

        $fabricante->delete();

        $this->dontSeeInDatabase('fabricante_softwares', ['nome' => 'Fabricante teste']);
    }
}
