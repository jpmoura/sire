<?php

use Illuminate\Database\Seeder;

class RegrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regras')->insert([
            'quantidade_horarios_matutino' => 4,
            'quantidade_horarios_vespertino' => 4,
            'quantidade_horarios_noturno' => 4,
            'quantidade_dias_reservaveis' => 5,
            'horario_inicio_matutino' => '08:00:00',
            'horario_inicio_vespertino' => '13:00:00',
            'horario_inicio_noturno' => '18:00:00',
            'tempo_duracao_horario' => '00:50:00',
            'quantidade_horarios_seguidos' => '2',
            'intervalo_entre_horarios_seguidos' => '00:30:00'
        ]);
    }
}
