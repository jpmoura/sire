<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'usuario_id', 'recurso_id', 'data', 'horario', 'turno',
    ];

    protected $hidden = [
        'id',
    ];

    /**
     * Recupera o usuário que realizou a alocação.
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usuario_id', 'cpf');
    }

    /**
     * Recupera o recurso alocado.
     */
    public function recurso()
    {
        return $this->belongsTo('App\Recurso');
    }
}
