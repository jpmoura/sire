<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaLegado extends Model
{
    public $table = 'reservas_legado';
    public $timestamps = false;

    protected $hidden = [
        'id',
    ];

    /**
     * Recupera o usuário da reserva feita no sistema legado.
     */
    public function usuario()
    {
        return $this->belongsTo('App\UsuarioLegado');
    }
}
