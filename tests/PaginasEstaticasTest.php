<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaginasEstaticasTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomeSemAutenticacao()
    {
        $this->visit('/')
             ->see("Sistema");
    }
}
