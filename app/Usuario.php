<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cpf', 'nome', 'email', 'nivel', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'id', 'remember_token',
    ];

    /**
     * Verifica se o usuário é um administrador do sistema.
     * @return bool True se o usuário é administrador e False caso contrário
     */
    public function isAdmin()
    {
        return $this->nivel == 1;
    }

    /**
     * Recupera os bugs relatados pelo usuário.
     */
    public function bugs()
    {
        return $this->hasMany('App\Bug');
    }

    /**
     * Recupera as reservas feitas pelo usuário.
     */
    public function reservas()
    {
        return $this->hasMany('App\Reserva', 'usuario_id', 'cpf');
    }
}
