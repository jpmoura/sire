<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioLegado extends Model
{
    public $timestamps = false;
    public $table = 'usuarios_legado';

    protected $hidden = [
        'id',
    ];

    /**
     * Recupera as reservas feitas pelo usuário no sistema legado.
     */
    public function reservas()
    {
        return $this->hasMany('App\ReservaLegado');
    }
}
