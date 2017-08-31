<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SoftwareTest extends TestCase
{

    use DatabaseTransactions;

    public function testInsert()
    {
        $fabricante = \App\FabricanteSoftware::create([
            'nome' => 'Fabricante teste'
        ]);

        \App\Software::create([
            'nome' => 'Teste',
            'versao' => '1.0',
            'instalado' => false,
            'fabricante_software_id' => $fabricante->id
        ]);

        $this->seeInDatabase('softwares', ['nome' => 'Teste', 'versao' => '1.0', 'status' => false, 'fabricante_software_id' => $fabricante->id]);
    }

    public function testUpdate()
    {
        $fabricante = \App\FabricanteSoftware::create([
            'nome' => 'Fabricante teste'
        ]);

        $software = \App\Software::create([
            'nome' => 'Teste',
            'versao' => '1.0',
            'status' => false,
            'fabricante_software_id' => $fabricante->id
        ]);

        $software->update([
            'nome' => 'alterado',
            'versao' => 'alterado',
            'status' => true,
        ]);

        $this->seeInDatabase('softwares', ['nome' => 'alterado', 'versao' => 'alterado', 'status' => true, 'fabricante_software_id' => $fabricante->id]);
    }

    public function testRemove()
    {
        $fabricante = \App\FabricanteSoftware::create([
            'nome' => 'Fabricante teste'
        ]);

        $software = \App\Software::create([
            'nome' => 'Teste',
            'versao' => '1.0',
            'instalado' => false,
            'fabricante_software_id' => $fabricante->id
        ]);

        $this->seeInDatabase('softwares', ['nome' => 'Teste', 'versao' => '1.0', 'status' => false, 'fabricante_software_id' => $fabricante->id]);

        $software->delete();

        $this->dontSeeInDatabase('softwares', ['nome' => 'Teste', 'versao' => '1.0', 'status' => false, 'fabricante_software_id' => $fabricante->id]);
    }
}
