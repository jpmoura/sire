<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegraTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Teste de edição de Regra.
     *
     * @return void
     */
    public function testEditarRegra()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $regra = factory(App\Regra::class)->create();
        $rota = route('regra.edit', $regra);

        $quantidade_horarios_matutino = 1;
        $quantidade_horarios_vespertino = 1;
        $quantidade_horarios_noturno = 1;
        $quantidade_dias_reservaveis = 1;
        $horario_inicio_matutino = "08:00:00";
        $horario_inicio_vespertino = "13:30:00";
        $horario_inicio_noturno = "18:50:00";
        $tempo_duracao_horario = "00:50:00";
        $quantidade_horarios_seguidos = 2;
        $intervalo_entre_horarios_seguidos = "00:20:00";

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->type($quantidade_horarios_matutino, "quantidade_horarios_matutino")
             ->type($quantidade_horarios_vespertino, "quantidade_horarios_vespertino")
             ->type($quantidade_horarios_noturno, "quantidade_horarios_noturno")
             ->type($quantidade_dias_reservaveis, "quantidade_dias_reservaveis")
             ->type($horario_inicio_matutino, "horario_inicio_matutino")
             ->type($horario_inicio_vespertino, "horario_inicio_vespertino")
             ->type($horario_inicio_noturno, "horario_inicio_noturno")
             ->type($tempo_duracao_horario, "tempo_duracao_horario")
             ->type($quantidade_horarios_seguidos, "quantidade_horarios_seguidos")
             ->type($intervalo_entre_horarios_seguidos, "intervalo_entre_horarios_seguidos")
             ->press("Confirmar")
             ->see("Sucesso")
             ->seeInDatabase("regras", [
                 "quantidade_horarios_matutino" => $quantidade_horarios_matutino,
                 "quantidade_horarios_vespertino" => $quantidade_horarios_vespertino,
                 "quantidade_horarios_noturno" => $quantidade_horarios_noturno,
                 "quantidade_dias_reservaveis" => $quantidade_dias_reservaveis,
                 "horario_inicio_matutino" => $horario_inicio_matutino,
                 "horario_inicio_vespertino" => $horario_inicio_vespertino,
                 "horario_inicio_noturno" => $horario_inicio_noturno,
                 "tempo_duracao_horario" => $tempo_duracao_horario,
                 "quantidade_horarios_seguidos" => $quantidade_horarios_seguidos,
                 "intervalo_entre_horarios_seguidos" => $intervalo_entre_horarios_seguidos,
             ]);
    }

    public function testIndiceRegra()
    {
        $usuarioAdministrador = factory(App\Usuario::class, 'admin')->create();
        $regra = factory(App\Regra::class)->create();
        $rota = route('regra.index');

        $regra = \App\Regra::first();

        $this->actingAs($usuarioAdministrador)
             ->visit($rota)
             ->see($regra->horario_inicio_matutino);
    }
}
