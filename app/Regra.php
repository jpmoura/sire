<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regra extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantidade_horarios_matutino', 'quantidade_horarios_vespertino', 'quantidade_horarios_noturno', 'quantidade_dias_reservaveis',
        'horario_inicio_matutino', 'horario_inicio_vespertino', 'horario_inicio_noturno', 'quantidade_horarios_seguidos',
        'intervalo_entre_horarios_seguidos', 'tempo_duracao_horario',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

}
